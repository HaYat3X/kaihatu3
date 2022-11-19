<?php

session_start();

// 外部ファイルおインポート
require '../../../class/SystemLogic.php';
require __DIR__ . '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StudentLogics();

// errメッセージが格納される配列を定義
$err_array = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $department = filter_input(INPUT_POST, 'department');
    $school_year = filter_input(INPUT_POST, 'school_year');
    $number = filter_input(INPUT_POST, 'number');

    // バリデーションエラーの画面表示
    if ($val_inst->student_register_full_registration_val($name, $password, $department, $school_year, $number)) {
        $argument = $arr_prm_inst->student_register_full_registration_prm($name, $email, $password, $department, $school_year, $number);

        // データ登録
        $sql = 'INSERT INTO `student_master`(`name`, `email`, `password`, `department`, `school_year`, `number`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)';

        $register = $db_inst->data_various_kinds($sql, $argument);

        if (!$register) {
            $err_array[] = '登録できませんでした';
        }
    } else {
        $err_array[] = $val_inst->getErrorMsg();
    }
} else {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #497174;
        }

        .nav-link {
            font-weight: bold;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: #EB6440;
            color: white;
        }

        .login-btn:hover {
            color: white;
            background-color: #eb6540c1;
        }

        .box {
            background-color: white;
            border-radius: 5px;
        }
    </style>
    <title>「Real IntentioN」 / 会員登録（学生）</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;"> Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./src/UserView/login/login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="box my-5 py-5">
            <div class="mx-auto col-lg-5">
                <?php if (count($err_array) > 0) : ?>
                    <?php foreach ($err_array as $err_mag) : ?>
                        <p class="fw-bold" style="color: red;">
                            <?php h($err_mag); ?>
                        </p>
                    <?php endforeach; ?>
                    <a class="btn btn-primary px-4" href="./full_registration_form.php?key=<?php h($_POST['email']) ?>">戻る</a>
                <?php endif; ?>

                <?php if (count($err_array) == 0) : ?>
                    <p class="fw-bold">ユーザ登録が完了しました。</p>
                    <?php $url = '../login/login_form.php'; ?>
                    <?php header('refresh:3;url=' . $url); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="../../../index.html" class="mb-3 me-2 mb-md-0
                                text-muted text-decoration-none lh-1"><img src="../../../public/img/logo.png" width="30px" height="30px" alt=""></a>
                    <span class="mb-3 mb-md-0" style="color: rgba(255,
                                255, 255, 0.697);">&copy;
                        2022 Toge-Company, Inc</span>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://github.com/Hayate12345">
                                <img src="../../../public/img/icons8-github-120.png" width="35px" height="35px" alt="">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://hayate-takeda.xyz/">
                                <img src="../../../public/img/icons8-ポートフォリオ-100.png" width="30px" height="30px" alt="">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://twitter.com/hayate_KIC">
                                <img src="../../../public/img/icons8-ツイッター-100.png" width="30px" height="30px" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>