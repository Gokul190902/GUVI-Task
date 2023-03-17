<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

class DbConnect {
    private $server = 'localhost';
    private $dbname = 'guvi';
    private $user = 'root';
    private $pass = "";

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            echo "Connection OK";
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
     
}

$email = $_POST['email'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$confirmPassword = $_POST['confirmPassword'];
$dob=$_POST['dob'];
$name=$_POST['name'];
$mobile=$_POST['mobile'];
$age=$_POST['age'];
// if (mysqli_query($conn, $sql)) {
//     echo "Table users created successfully";
// } else {
//     echo "Error creating table: " . mysqli_error($conn);
// }

$uri = 'mongodb+srv://Gokul:19sep2002@cluster0.keckclg.mongodb.net/';
$manager = new MongoDB\Driver\Manager($uri);

$database = "guvi";
$collection = "users";

$bulk = new MongoDB\Driver\BulkWrite;

$document = [
    'email' => $email,
    'dob' => $dob,
    'age' => $age,
    'contact'=>$mobile,
    'name'=>$name
];

$bulk = new MongoDB\Driver\BulkWrite;

// Add insert operation to bulk write object
$_id = $bulk->insert($document);

// Create MongoDB write concern object
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

// Execute bulk write operation
$result = $manager->executeBulkWrite("$database.$collection", $bulk, $writeConcern);
// Print result

printf("Inserted %d document(s)\n", $result->getInsertedCount());
$mongoId = (string)$_id;
printf($mongoId);
$objDb = new DbConnect;
$conn = $objDb->connect();
$sql = "INSERT INTO users (email, password ,mongodbId) VALUES (:email, :password,:mongoId)";
$stmt = $conn->prepare($sql);

    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mongoId',$mongoId);

// if(mysqli_query($conn,$sql))
// {
//     echo "Data inserted successfully";
// }
if ($stmt->execute()) {
    $data['success'] = true;
    $data['errors'] = false;
    $data['message'] = 'Success!';
} else {
    $errors['login'] = "SignUp Failed";
    $data['success'] = false;
}
echo json_encode($data);
?>