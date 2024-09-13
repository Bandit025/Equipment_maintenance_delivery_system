<?php
session_start();

// ลบ session ทั้งหมด
session_destroy();

// Redirect ผู้ใช้งานกลับไปยังหน้า login
echo '<script>alert("ออกจากระบบเรียบร้อย")</script>';
        header('refresh:1;index.php');
exit;
?>