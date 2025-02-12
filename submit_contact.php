<?php
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root"; // اسم المستخدم الافتراضي في XAMPP
$password = ""; // كلمة المرور الافتراضية في XAMPP
$dbname = "contact_form"; // اسم قاعدة البيانات

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التحقق من نوع الطلب
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // إدخال البيانات
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $message = isset($_POST['message']) ? $_POST['message'] : null;

    // التحقق من أن جميع الحقول ممتلئة
    if ($name && $email && $message) {
        // إعداد الاستعلام مع اسم الجدول الصحيح
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // ربط البيانات
            $stmt->bind_param("sss", $name,  $email, $message);

            // تنفيذ الاستعلام
            if ($stmt->execute()) {
                echo "تم إرسال الرسالة بنجاح!";
            } else {
                echo "حدث خطأ أثناء إرسال الرسالة: " . $stmt->error;
            }

            // إغلاق البيان
            $stmt->close();
        } else {
            echo "خطأ في إعداد الاستعلام: " . $conn->error;
        }
    } else {
        echo "يرجى ملء جميع الحقول.";
    }
}

// إغلاق الاتصال
$conn->close();
?>
