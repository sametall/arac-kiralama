<?php

require_once 'db.php';

if (isset($_POST['submit'])) {
    try {
        $id = intval($_POST['id']);
        $name = htmlspecialchars(trim($_POST['name']));
        $model = htmlspecialchars(trim($_POST['model']));
        $description = $_POST['description'];

        if (!empty($name) && !empty($model) && !empty($description)) {
            if (!empty($id)) {
                $sql = "UPDATE arac SET arac_adi = :name, arac_model = :model, arac_aciklama = :description WHERE id = :id";
            } else {
                $sql = "INSERT INTO arac (arac_adi, arac_model, arac_aciklama) VALUES (:name, :model, :description)";
            }

            $query = $db->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':model', $model);
            $query->bindParam(':description', $description);
            if (!empty($id)) {
                $query->bindParam(':id', $id, PDO::PARAM_INT);
            }

            $query->execute();

            $_SESSION['success'] = 'İşlem başarıyla gerçekleştirildi.';
        } else {
            $_SESSION['error'] = 'Lütfen tüm alanları doldurun.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Beklenmedik bir hata oluştu. Hata: {$e->getMessage()}";
    } finally {
        header("Location: {$clientPrefix}/396487_ana.php");
        exit;
    }
} else if (isset($_GET['process'])) {
    if ($_GET['process'] === 'delete') {
        try {
            $id = intval($_GET['id']);

            if (!empty($id)) {
                $sql = "DELETE FROM arac WHERE id = :id";
                $query = $db->prepare($sql);
                $query->bindParam(':id', $id, PDO::PARAM_INT);
                $query->execute();
                $_SESSION['success'] = 'Veri başarıyla silindi.';
            } else {
                $_SESSION['error'] = 'Geçersiz veri IDsi.';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Beklenmedik bir hata oluştu. Hata: {$e->getMessage()}";
        } finally {
            header("Location: {$clientPrefix}/396487_ana.php");
            exit;
        }
    }
} else {
    header("Location: {$clientPrefix}/396487_ana.php?status=404");
    exit;
}
