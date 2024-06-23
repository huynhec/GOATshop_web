import pandas as pd
import json

def convert_to_desired_format(input_excel, output_txt):
    orders = {}
    
    # Read the Excel file
    df = pd.read_excel(input_excel)
    
    # Iterate over each row in the dataframe
    for _, row in df.iterrows():
        m_order = str(row['makh'])
        m_product = str(row['masp'])
        if m_order in orders:
            if m_product not in orders[m_order]:
                orders[m_order].append(m_product)
        else:
            orders[m_order] = [m_product]

    # Print the formatted output
    for order, products in orders.items():
        print(f"{order}, {json.dumps(products)}")
        
    # Save the formatted output to a new file
    with open(output_txt, 'w', encoding='utf-8') as output_file:
        for order, products in orders.items():
            output_file.write(f"{order}, {json.dumps(products)}\n")

# Execute the function
convert_to_desired_format('admin/pages/Association-Rules/dataset/viewlist.xlsx', 'admin/pages/Association-Rules/dataset/formatted_orders.txt')
