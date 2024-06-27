
# Cấu hình XAMPP
- php.ini
    + post_max_size=1G
    + upload_max_filesize=1G
    + memory_limit=1G
    + max_file_uploads=200
    + extension=gd

- my.ini
    + max_allowed_packet=1G

# Import database
    + football_db.sql

# Account
    - Tài khoản admin
        + username: admin
        + password: 123456
    - Tài khoản manager
        + username: manager
        + password: 123456
    - Tài khoản nhan vien
        + username: staff
        + password: 123456
    - Tài khoản user
        + username: khachhang
        + password: 123456
        
# 1. Tạo môi trường conda (nếu chưa tạo)
conda create -n code python=3.9

# 2. Activate env (Trước khi chạy các file code)
cmd (chỉ nhập cmd trên Windows, MacOS không cần)
conda activate code

# 3. Cài packages
pip install -r requirements.txt

# 4. Run predict
python main.py -min_quota=10 -k=2 -file_name="datasets/data.xlsx"

# test