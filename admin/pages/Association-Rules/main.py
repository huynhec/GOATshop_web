import ast
import datetime
import itertools
from collections import defaultdict, Counter
from openpyxl import Workbook

# Khởi tạo các biến
support = 1
confidence = 1
current_time = datetime.datetime.now().strftime("%Y-%m-%d_%H-%M-%S")

input_file = "dataset/formatted_orders.txt"
output_file = f"output/output_rules.txt"
excel_output_file = f"output/output_rules.xlsx"

# Đọc dữ liệu và xây dựng C1 và D
C1 = defaultdict(int)
transactions = 0
D = []

with open(input_file, "r") as f:
    next(f)  # Bỏ qua tiêu đề
    for line in f:
        transactions += 1
        parts = line.strip().split(",", 1)
        items_str = parts[1].strip()
        try:
            items = ast.literal_eval(items_str)
        except (SyntaxError, ValueError) as e:
            print(f"Error parsing line {transactions}: {e}")
            continue
        for item in items:
            C1[item] += 1
        D.append(set(items))  # Chuyển items thành set để tối ưu tính toán sau này

# Ghi thông tin ban đầu vào file output
with open(output_file, "a") as f:
    f.write(f"support: {support}\n")
    f.write(f"confidence: {confidence}\n")
    f.write(f"datetime: {datetime.datetime.now()}\n")
    f.write(f"TEST DATASET: {D}\n")
    f.write(f"CANDIDATE 1-ITEMSET: {dict(C1)}\n")

# Tạo tập phổ biến 1 mục
L1 = [[key] for key in C1 if (100 * C1[key] / transactions) >= support]

with open(output_file, "a") as f:
    f.write(f"FREQUENT 1-ITEMSET: {L1}\n")

def apriori_gen(Lk_1, k):
    Ck = []
    for list1 in Lk_1:
        for list2 in Lk_1:
            if list1[:-1] == list2[:-1] and list1[-1] < list2[-1]:
                candidate = list1 + [list2[-1]]
                if not has_infrequent_subset(set(candidate), Lk_1):
                    Ck.append(candidate)
    return Ck

def findsubsets(S):
    return set(itertools.chain.from_iterable(itertools.combinations(S, r) for r in range(1, len(S))))

def has_infrequent_subset(c, Lk_1):
    subsets = findsubsets(c)
    for subset in subsets:
        if list(subset) not in Lk_1:
            return True
    return False

def frequent_itemsets(file):
    k = 2
    Lk_1 = L1
    L = [L1]
    while Lk_1:
        Ck = apriori_gen(Lk_1, k - 1)
        Lk = []
        itemset_count = Counter()
        for T in D:
            for c in Ck:
                if set(c).issubset(T):
                    itemset_count[tuple(c)] += 1
        for c, count in itemset_count.items():
            if (100 * count / transactions) >= support:
                Lk.append(list(c))
        
        with open(file, "a") as f:
            f.write(f"CANDIDATE {k}-ITEMSET: {Ck}\n")
            f.write(f"FREQUENT {k}-ITEMSET: {Lk}\n")

        Lk_1 = Lk
        if Lk:
            L.append(Lk)
        k += 1
    return L

def generate_association_rules(file, excel_file):
    L = frequent_itemsets(file)
    wb = Workbook()
    ws = wb.active
    ws.title = "Association Rules"
    ws.append(["Rule#", "Antecedent", "Consequent", "Support", "Confidence"])
    rule_number = 1

    with open(file, "a") as f:
        f.write("RULES \t SUPPORT \t CONFIDENCE\n")

    for itemset in L:
        for l in itemset:
            for count in range(1, len(l)):
                subsets = findsubsets(l)
                for antecedent in subsets:
                    antecedent = list(antecedent)
                    consequent = [item for item in l if item not in antecedent]
                    support_val = sum(1 for T in D if set(l).issubset(T)) / transactions
                    antecedent_count = sum(1 for T in D if set(antecedent).issubset(T))
                    if antecedent_count == 0:
                        continue  # Bỏ qua nếu antecdent không xuất hiện trong giao dịch nào
                    confidence_val = sum(1 for T in D if set(l).issubset(T)) / antecedent_count
                    if confidence_val >= confidence / 100:
                        rule = f"Rule# {rule_number}: {antecedent} ==> {consequent} (Support: {support_val * 100:.2f}%, Confidence: {confidence_val * 100:.2f}%)\n"
                        with open(file, "a") as f:
                            f.write(rule)
                        ws.append([rule_number, ', '.join(map(str, antecedent)), ', '.join(map(str, consequent)), f"{support_val * 100:.2f}", f"{confidence_val * 100:.2f}"])
                        rule_number += 1

    wb.save(excel_file)

generate_association_rules(output_file, excel_output_file)
