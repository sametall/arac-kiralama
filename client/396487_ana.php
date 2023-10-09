<?php
require_once '../server/db.php';

if (isset($_GET['process']) && $_GET['process'] === 'update') {
    try {
        // Formdan gelen değerleri al
        $id = $_GET['id'];
        // id değerine göre veritabanından kaydı getir
        $sql = "SELECT * FROM arac WHERE id = $id";
        $query = $db->prepare($sql);
        $query->execute();
        $vehicles = $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Beklenmedik bir hata oluştu. Hata: {$e->getMessage()}";
    }
}

?>

<!DOCTYPE html>
<html lang="tr_TR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="@samet396487">
    <meta name="description" content="YBS 2023 Web Uygulaması">
    <title>YBS 2023 | SAMET - 396487</title>
    <!-- Bootstrap CDN CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="for-form mt-5">
            <h3 class="text-center">Veri Tabanı İşlemleri</h3>
            <form action="<?= $serverPrefix ?>/index.php" method="POST">
                <input type="hidden" name="id" value="<?= $vehicles->id ?? '' ?>">
                <div class="form-group">
                    <label for="name">Araç Adı</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Araç adını giriniz..." required value="<?= $vehicles->arac_adi ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="model">Araç Modeli</label>
                    <input type="number" name="model" id="model" class="form-control" placeholder="Araç modelini giriniz..." required value="<?= $vehicles->arac_model ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="description">Araç Açıklaması</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Araç açıklamasını giriniz..." required><?= $vehicles->arac_aciklama ?? '' ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" value="1">
                    <?= isset($messages->id) ? 'Güncelle' : 'Kaydet' ?>
                </button>
            </form>

            <?php if (isset($_SESSION['success'])) : ?>
                <div class="mt-5 alert alert-success">
                    <?= $_SESSION['success'] ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="mt-5 alert alert-danger">
                    <?= $_SESSION['error'] ?>
                </div>
            <?php endif; ?>
            <?php session_destroy(); ?>
        </div>
        <hr>
        <div class="for-datatable mt-5">
            <h3 class="text-center">Veri Tabanı Tablosu</h3>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>Araç Adı</th>
                            <th>Araç Modeli</th>
                            <th>Araç Açıklaması</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM arac";
                        $query = $db->prepare($sql);
                        $query->execute();
                        $vehicles = $query->fetchAll(PDO::FETCH_OBJ);
                        ?>
                        <?php foreach ($vehicles as $val) : ?>
                            <tr>
                                <td><?= $val->id ?></td>
                                <td><?= $val->arac_adi ?></td>
                                <td><?= $val->arac_model ?></td>
                                <td><?= strlen($val->arac_aciklama) > 50 ? substr($val->arac_aciklama, 0, 50) . '...' : $val->arac_aciklama ?></td>
                                <td>
                                    <a href="<?= $clientPrefix ?>/396487_ana.php?process=update&id=<?= $val->id ?>" class="btn btn-warning">Güncelle</a>
                                    <a href="<?= $serverPrefix ?>/index.php?process=delete&id=<?= $val->id ?>" class="btn btn-danger" id="isDelete">Sil</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap CDN JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>

</body>

</html>