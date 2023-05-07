<?php
include_once '../config/database.php';
$database = new Database();

class PromoCode {
    private $conn;
    private $table_name = "promocodes";
    private $promo_code;
    private $discount;
    private $expiration_date;
    
    public function __construct($db){
        $this->conn = $db;
    }
    
    
    public function getPromoCode() {
    return $this->promo_code;
    }
    
    public function getDiscount() {
    return $this->discount;
    }
    
    public function getExpirationDate() {
    return $this->expiration_date;
    }

    public function savePromocode($pc,$discount,$exp){
        
        $query = "INSERT INTO " . $this->table_name . " SET ";
        $query .= "promo_code=:pc, ";
        $query .= "discount_percentage=:discount, ";
        $query .= "end_date=:exp ";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":pc", $pc);
        $stmt->bindParam(":discount", $discount);
        $stmt->bindParam(":exp", $exp);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return -1;
        }
    }
    public function sendMailToUsers($to,$promocode,$discount,$exp){
        ini_set('SMTP', 'mazinislam431@gmail.com');
ini_set('smtp_port', 25);
        $subject = 'Your Promo Code';
        $message = "Here is your promo code: $promocode. It expires on $exp. You get a $discount discount on your next purchase.";
        $headers = 'From: mazinislam431@gmail.com' . "\r\n" .
        'Reply-To: mazinislam431@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $message = wordwrap($message,70);
        mail($to, $subject, $message, $headers);
    }
    }
    ?>