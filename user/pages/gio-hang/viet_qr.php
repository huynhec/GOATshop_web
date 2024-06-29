    <?php
    function removeAccents($string)
    {
        if (!$string) return false;

        $accents = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($accents as $char => $pattern) {
            $string = preg_replace("/$pattern/i", $char, $string);
        }

        return $string;
    }

    // function generateQRCode($bankCode, $accountNumber, $qrType, $accountName, $amount, $additionalInfo)
    // {
    //     $accountName = str_replace(" ", "%20", removeAccents($accountName));
    //     $additionalInfo = str_replace(" ", "%20", removeAccents($additionalInfo));

    //     $url = "https://img.vietqr.io/image/$bankCode-$accountNumber-$qrType?accountName=$accountName&amount=$amount&addInfo=$additionalInfo";

    //     $img = 'qr.png';
    //     $file = file_get_contents($url);
    //     $result = file_put_contents($img, $file);

    //     return $result !== false;
    // }
    function generateQRCode($bankCode, $accountNumber, $qrType, $accountName, $amount, $additionalInfo)
    {
        $accountName = str_replace(" ", "%20", removeAccents($accountName));
        $additionalInfo = str_replace(" ", "%20", removeAccents($additionalInfo));

        $url = "https://img.vietqr.io/image/$bankCode-$accountNumber-$qrType?accountName=$accountName&amount=$amount&addInfo=$additionalInfo";

        return $url;
    }

    $madon = isset($_GET['madon']) ? $_GET['madon'] : '';
    $total_amount = isset($_GET['total_amount']) ? $_GET['total_amount'] : '';
    // // Dữ liệu đầu vào
    // $bankCode = "970415";
    // $accountNumber = "100878676169";
    // $accountHolderName = "NHOM TRE LOP MAU GIAO DOC LAP TU THUC KIM DONG";
    // $qrType = 'print.jpg';
    // $transactionTime = date('Y-m-d H:i:s');
    // $transferAmount = "200000";
    // $recipient = "Customer 1";

    // // Tạo nội dung chuyển khoản và tạo mã QR
    // $content = $recipient . " " . $transactionTime;
    // $success = generateQRCode($bankCode, $accountNumber, $qrType, $accountHolderName, $transferAmount, $content);

    // if ($success) {
    //     echo "QR code generated successfully.";
    // } else {
    //     echo "Failed to generate QR code.";
    // }
    // Dữ liệu đầu vào
    $bankCode = "970407";
    $accountNumber = "19071098674018";
    $accountHolderName = "NGUYEN HUYNH";
    $qrType = "print.jpg";
    $transactionTime = date('Y/m/d H:i:s');
    // $transferAmount = number_format($ctgh->ChiTietGioHang__Sum_Tien_GH($item->magh)->sum_tien);
    $transferAmount = $total_amount;
    $recipient = "NGUYEN HUYNH";

    $content = " Ma don: " . $madon . "\n"
        . " So tien: " . $transferAmount . "\n";
    //tạo mã qr
    $qrUrl = generateQRCode($bankCode, $accountNumber, $qrType, $accountHolderName, $transferAmount, $content);

    ?>
    <div class="radio-wrapper" for="payment_method_id_1002112115">
        <div class="col" id="blank-slate">
            <?php
            // in hình
            echo '<img src="' . $qrUrl . '" alt="QR Code">';
            ?>
            <div class="alert alert-success text-center" role="alert">
                NH Vietcombank Chi nhánh Tân Định
                TK: Le Thanh Chau
                STK: 0371000478398
            </div>
            <p class="text-center">Trở về <a href="../../index.php">trang chủ</a></p>
        </div>
    </div>

    <style>
        .radio-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 0 2rem;
        }
        .text-home {
            font-size: 36px;
            /* padding-left: 20rem; */
            margin: 0;
            text-align: center;
        }
    </style>