<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/SystemLogic.php';
require '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StaffLogics();

// ログインチェック
$userId = $student_inst->get_staff_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}


if (!$delete_post_id = filter_input(INPUT_GET, 'post_id')) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
};

// SQL発行
$sql = 'DELETE FROM `staff_information_table` WHERE post_id = ?';
$argument = $arr_prm_inst->student_post_one_prm($delete_post_id);

// 削除実行
$delete = $db_inst->data_various_kinds($sql, $argument);

$err_array = [];

if (!$delete) {
    $err_array[] = '削除に失敗しました。';
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
    <title>「Real IntentioN」 / ログイン（学生）</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="./view.php">
                    <img src="../../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <main role="main" class="container my-5" style="padding: 0px">
        <div class="row">
            <div class="col-md-8">
                <div class="bg-light">
                    <div class="mx-auto col-lg-8 pt-3 pb-3">
                        <?php if (count($err_array) > 0) : ?>
                            <?php foreach ($err_array as $err_msg) : ?>
                                <label><?php h($err_msg); ?></label>
                                <div class="backBtn">
                                    <a href="../view.php">戻る</a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (count($err_array) === 0) : ?>
                            <p class="fw-bold">削除が完了しました。</p>
                            <?php header('refresh:3;url=../post_list.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="side-bar col-md-4 bg-light sticky-top h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a style="background-color: #EB6440;" href="./view.php" class="nav-link active" aria-current="page">
                                インターン体験記
                            </a>
                        </li>
                        <li>
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                インターン / イベント情報 / 説明会情報
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>



    <footer>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="../../../index.html" class="mb-3 me-2 mb-md-0
                                text-muted text-decoration-none lh-1"><img src="../../../../public/img/logo.png" width="30px" height="30px" alt=""></a>
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
                                <img src="../../../../public/img/icons8-github-120.png" width="35px" height="35px" alt="">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://hayate-takeda.xyz/">
                                <img src="../../../../public/img/icons8-ポートフォリオ-100.png" width="30px" height="30px" alt="">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://twitter.com/hayate_KIC">
                                <img src="../../../../public/img/icons8-ツイッター-100.png" width="30px" height="30px" alt="">
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