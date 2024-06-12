import argparse
import os
import numpy as np
from openpyxl import Workbook
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from datetime import datetime
import logging
from surprise import Dataset, Reader, KNNBasic
from surprise.model_selection import train_test_split, cross_validate
import numpy as np

# Hàm để ghi log thông báo
def log(message):
    logging.info(message)
    print(message)

# Hàm tìm các cặp (user, item) bị trùng lặp
def find_duplicates(df):
    duplicates = df[df.duplicated(subset=['user', 'item'], keep=False)]
    if not duplicates.empty:
        log("Các cặp (user, item) bị trùng lặp:")
        log(duplicates)
    else:
        log("Không có cặp (user, item) nào bị trùng lặp.")
    return duplicates

# Hàm lọc dữ liệu
def filter_data(df, min_quota=5):
    # Xóa các hàng có giá trị bị thiếu
    df = df.dropna(subset=['user', 'item', 'rating'])
    
    # Kiểm tra và loại bỏ các giá trị không phải số trong cột 'rating'
    df.loc[:, 'rating'] = pd.to_numeric(df['rating'], errors='coerce')
    # Xử lý các cặp (user, item) trùng lặp bằng cách lấy giá trị trung bình
    df = df.groupby(['user', 'item']).agg({'rating': 'mean'}).reset_index()
    
    # Loại bỏ các item không có đủ số lượt rating
    item_counts = df['item'].value_counts()
    valid_items = item_counts[item_counts >= min_quota].index
    df = df[df['item'].isin(valid_items)]
    
    return df

# Hàm tải và chuyển đổi dữ liệu
def load_data(file_name, folder_name, min_quota):
    # Đọc dữ liệu từ file Excel
    df = pd.read_excel(file_name)
    
    # Check trùng
    find_duplicates(df)
    
    # Tiền xử lý
    df = filter_data(df, min_quota)
    
    # Pivot dữ liệu để có ma trận người dùng - item
    df_pivot = df.pivot(index='user', columns='item', values='rating').reset_index()
    df_pivot.columns.name = None
    df_pivot.columns = [str(col).title() for col in df_pivot.columns]
    
    # Lưu dữ liệu đã chuyển đổi vào một file mới
    os.makedirs(folder_name, exist_ok=True)
    # Lưu ma trận gốc
    df_pivot.to_excel(os.path.join(folder_name, '1_original_matrix.xlsx'), index=False)
    trans_file_name = f'{folder_name}/1_original_matrix.xlsx'
    log(f"Dữ liệu đã được tải từ file: {trans_file_name}")
    
    # Đọc dữ liệu đã chuyển đổi từ file
    return pd.read_excel(trans_file_name),

# Hàm tính toán ma trận độ tương tự giữa các user
def calculate_user_similarity(data_matrix):
    cos_sim = cosine_similarity(data_matrix, data_matrix)
    cos_sim = np.round(cos_sim, decimals=2)
    log("Ma trận độ tương tự giữa các user đã được tính toán")
    return cos_sim

# Hàm dự đoán rating sử dụng collaborative filtering cho user
def predict_user_based(A, u, i, cos_sim, k):
    user_rated_i = np.where(A[:, i] != 0)[0]
    if len(user_rated_i) == 0:
        return np.nan
    sim = cos_sim[u, user_rated_i]
    a = np.argsort(sim)[-k:]
    nearest_s = sim[a]
    rating = A[user_rated_i[a], i]
    r_bar = (rating * nearest_s).sum() / (np.abs(nearest_s).sum())
    return np.round(r_bar)

# Hàm tạo ma trận dự đoán dựa trên các user
def generate_prediction_matrix_user_based(data_matrix, cos_sim, k):
    predict_matrix = data_matrix.copy()
    for u in range(predict_matrix.shape[0]):
        for i in range(predict_matrix.shape[1]):
            if data_matrix[u, i] == 0:
                predict_matrix[u, i] = predict_user_based(data_matrix, u, i, cos_sim, k)
    return predict_matrix

# Hàm gợi ý item cho một người dùng cụ thể
def suggest_for_user(user_name, data, predict_matrix):
    user_index = data[data.iloc[:, 0] == user_name].index[0]
    user_ratings = predict_matrix[user_index]
    suggested_items = data.columns[1:][np.argsort(user_ratings)[::-1]]
    return suggested_items

# Hàm hiển thị và lưu kết quả
def display_and_save_results(data, cos_sim, predict_matrix):
    log("Ma trận gốc:")
    log(data.to_string())
    log("Ma trận độ tương tự cosine:")
    log(pd.DataFrame(cos_sim, columns=data.iloc[:, 0], index=data.iloc[:, 0]).to_string())
    log("Ma trận dự đoán:")
    log(pd.DataFrame(predict_matrix, columns=data.columns[1:], index=data.iloc[:, 0]).to_string())
    
    # Tạo thư mục nếu chưa tồn tại
    os.makedirs(folder_name, exist_ok=True)
    # Lưu ma trận độ tương tự cosine
    pd.DataFrame(cos_sim, columns=data.iloc[:, 0], index=data.iloc[:, 0]).to_excel(os.path.join(folder_name, '2_cosine_similarity_matrix.xlsx'))
    # Lưu ma trận dự đoán
    pd.DataFrame(predict_matrix, columns=data.columns[1:], index=data.iloc[:, 0]).to_excel(os.path.join(folder_name, '3_prediction_matrix.xlsx'))

# Hàm lưu tất cả các item được gợi ý cho mỗi người dùng vào file Excel
def save_all_suggested_items(user_items_mapping, folder_name):
    file_output = f"{folder_name}/4_prediction_export.xlsx"
    wb = Workbook()
    ws = wb.active
    ws.append(['user', 'rank', 'item'])
    for user_name, suggested_items in user_items_mapping.items():
        for idx, item in enumerate(suggested_items, start=1):
            ws.append([user_name, idx, item])
    wb.save(file_output)
    log(f"Đã lưu file gợi ý: {file_output}")

# Hàm xử lý dữ liệu
def process_data(data):
    item = list(data.columns[1:])
    user = list(data.iloc[:, 0])
    data_matrix = data[item].fillna(0).values
    return item, user, data_matrix

# Đánh giá độ lỗi
from surprise.model_selection import cross_validate

# Hàm đánh giá độ lỗi sử dụng cross-validation
def cross_val(file_name, min_quota, k):
    try:
        # Đọc dữ liệu từ file Excel
        df = pd.read_excel(file_name)

        # Check trùng
        find_duplicates(df)

        # Tiền xử lý
        df = filter_data(df, min_quota)

        # Sử dụng Reader từ Surprise để chỉ định cấu trúc dữ liệu
        reader = Reader(rating_scale=(1, 5))

        # Tạo Dataset từ dữ liệu DataFrame và Reader
        data = Dataset.load_from_df(df[['user', 'item', 'rating']], reader)

        # Sử dụng KNNBasic làm mô hình
        sim_options = {'name': 'cosine', 'user_based': True}
        algo = KNNBasic(k=k, sim_options=sim_options)

        # Thực hiện cross-validation
        cv_results = cross_validate(algo, data, measures=['RMSE', 'MAE'], cv=5, verbose=True)

        # Lấy trung bình các kết quả từ cross-validation
        mean_rmse = np.mean(cv_results['test_rmse'])
        mean_mae = np.mean(cv_results['test_mae'])

        log(f"Mean RMSE: {mean_rmse}")
        log(f"Mean MAE: {mean_mae}")
    except Exception as e:
        logging.error(f"Có lỗi xảy ra trong quá trình cross-validation: {str(e)}", exc_info=True)

# Hàm log để chạy toàn bộ quy trình
def main(file_name, min_quota, k):
    try:
        log("Thông tin đầu vào:")
        log(f"file_name: {file_name}")
        log(f"min_quota: {min_quota}")
        log(f"k: {k}")
        log("----------------------------------------------")
        log(f"Kết quả thực thi:")
        
        start_time = datetime.now()

        # Tải và xử lý dữ liệu
        
        data_tuple = load_data(file_name, folder_name, min_quota)
        data = data_tuple[0]
        item, user, data_matrix = process_data(data)

        # Tính toán ma trận độ tương tự cosine
        global cos_sim
        cos_sim = calculate_user_similarity(data_matrix)

        # Tạo ma trận dự đoán
        predict_matrix = generate_prediction_matrix_user_based(data_matrix, cos_sim, k)

        # Hiển thị kết quả
        display_and_save_results(data, cos_sim, predict_matrix)

        # Gợi ý các item cho từng người dùng
        user_items_mapping = {}
        for user_name in user:
            suggested_items = suggest_for_user(user_name, data, predict_matrix)
            user_items_mapping[user_name] = suggested_items

        # Đánh giá độ lỗi
        cross_val(file_name, min_quota, k)

        log(f"Thời gian thực thi: {datetime.now() - start_time}")

        # Lưu tất cả các mặt hàng được gợi ý vào file Excel
        save_all_suggested_items(user_items_mapping, folder_name)
    except Exception as e:
        logging.error(f"Có lỗi xảy ra: {str(e)}", exc_info=True)


if __name__ == "__main__":
    now = datetime.now()
    folder_name = f"results/{now.strftime('%Y-%m-%d')}"
    
    # Kiểm tra nếu thư mục đã tồn tại, không cần tạo lại
    if not os.path.exists(folder_name):
        os.makedirs(folder_name)
    
    file_log = f"{folder_name}/1_log_{now.strftime('%Y-%m-%d-%H-%M-%S')}.log"
    logging.basicConfig(filename=file_log, level=logging.INFO, encoding="UTF-8",
                        format='%(asctime)s - %(levelname)s - %(message)s')
    
    parser = argparse.ArgumentParser(description='python main.py -file_name -min_quota -k')
    parser.add_argument('-min_quota', type=int, default=0, help='enter min_quota')
    parser.add_argument('-k', type=int, default=2, help='enter k')
    parser.add_argument('-file_name', type=str, default="datasets/training_user_based.xlsx", help='enter file_name')
    
    args = parser.parse_args()
    main(args.file_name, args.min_quota, args.k)
