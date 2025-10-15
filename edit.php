<?php include 'db.php'; ?>
<?php
$user = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
    $mother_name = mysqli_real_escape_string($conn, $_POST['mother_name']);
    $nid_birth = mysqli_real_escape_string($conn, $_POST['nid_birth']);
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $marital_status = mysqli_real_escape_string($conn, $_POST['marital_status']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $religion = mysqli_real_escape_string($conn, $_POST['religion']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $upazila = mysqli_real_escape_string($conn, $_POST['upazila']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);

    $sql = "UPDATE users SET 
            full_name = '$full_name', 
            father_name = '$father_name', 
            mother_name = '$mother_name', 
            nid_birth = '$nid_birth', 
            dob = '$dob', 
            age = '$age', 
            gender = '$gender', 
            marital_status = '$marital_status', 
            blood_group = '$blood_group', 
            religion = '$religion', 
            email = '$email', 
            phone = '$phone', 
            district = '$district', 
            upazila = '$upazila', 
            address = '$address', 
            education = '$education', 
            profession = '$profession'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?message=User updated successfully&type=success");
        exit();
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit User</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      background: #fff;
      padding: 30px 40px;
      border-radius: 20px;
      max-width: 1000px;
      width: 100%;
      border: none;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .container:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    h2 {
      color: #2c3e50;
      font-size: 2.2rem;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .subtitle {
      color: #7f8c8d;
      font-size: 1.1rem;
    }

    .nav-links {
      text-align: center;
      margin-bottom: 25px;
    }

    .nav-links a {
      display: inline-block;
      margin: 0 10px;
      padding: 10px 20px;
      background: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 25px;
      transition: all 0.3s ease;
      font-weight: 600;
    }

    .nav-links a:hover {
      background: #2980b9;
      transform: translateY(-2px);
    }

    .message {
      padding: 15px 20px;
      margin: 20px 0;
      border-radius: 10px;
      text-align: center;
      font-weight: 600;
      font-size: 1rem;
      border: 2px solid transparent;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
      border-color: #f5c6cb;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .form-group {
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
    }

    .full-width {
      grid-column: span 2;
    }

    .form-group label {
      margin-bottom: 8px;
      font-weight: 600;
      color: #2c3e50;
      font-size: 0.95rem;
    }

    .required::after {
      content: " *";
      color: #e74c3c;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: 12px 15px;
      border: 2px solid #e1e8ed;
      border-radius: 10px;
      font-size: 1rem;
      outline: none;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
      background: #fff;
      transform: translateY(-1px);
    }

    .form-group .radio-group {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 5px;
    }

    .form-group .radio-group label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: normal;
      cursor: pointer;
      padding: 8px 15px;
      background: #f8f9fa;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .form-group .radio-group label:hover {
      background: #e9ecef;
    }

    input[type="radio"] {
      transform: scale(1.1);
    }

    .button-group {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-top: 10px;
    }

    .submit-btn {
      padding: 15px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, #27ae60, #2ecc71);
      color: #fff;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
    }

    .submit-btn:hover {
      background: linear-gradient(135deg, #229954, #27ae60);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
    }

    .cancel-btn {
      padding: 15px;
      border: 2px solid #e74c3c;
      border-radius: 12px;
      background: transparent;
      color: #e74c3c;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .cancel-btn:hover {
      background: #e74c3c;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3);
    }

    .file-upload {
      position: relative;
      overflow: hidden;
    }

    .file-upload input[type="file"] {
      position: absolute;
      left: 0;
      top: 0;
      opacity: 0;
      cursor: pointer;
    }

    .file-upload-label {
      display: block;
      padding: 12px 15px;
      background: #f8f9fa;
      border: 2px dashed #bdc3c7;
      border-radius: 10px;
      text-align: center;
      color: #7f8c8d;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .file-upload-label:hover {
      border-color: #3498db;
      background: #e3f2fd;
    }

    .section-title {
      grid-column: span 2;
      font-size: 1.3rem;
      color: #2c3e50;
      margin: 20px 0 10px 0;
      padding-bottom: 10px;
      border-bottom: 2px solid #3498db;
      font-weight: 700;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        margin: 10px;
      }

      .form-grid {
        grid-template-columns: 1fr;
      }

      .full-width {
        grid-column: span 1;
      }

      .button-group {
        grid-template-columns: 1fr;
      }

      h2 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Edit User</h2>
      <p class="subtitle">Update user information</p>
    </div>

    <div class="nav-links">
      <a href="dashboard.php">📊 Back to Dashboard</a>
      <a href="register.php">➕ Add New User</a>
    </div>

    <?php if (isset($error)): ?>
      <div class="message error">
        ❌ <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <?php if ($user): ?>
    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
      
      <div class="form-grid">
        
        <div class="section-title">Personal Information</div>

        <!-- Personal Info -->
        <div class="form-group">
          <label class="required">Full Name</label>
          <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>

        <div class="form-group">
          <label class="required">Father's Name</label>
          <input type="text" name="father_name" value="<?php echo htmlspecialchars($user['father_name']); ?>" required>
        </div>

        <div class="form-group">
          <label class="required">Mother's Name</label>
          <input type="text" name="mother_name" value="<?php echo htmlspecialchars($user['mother_name']); ?>" required>
        </div>

        <div class="form-group">
          <label class="required">NID / Birth Certificate No.</label>
          <input type="text" name="nid_birth" value="<?php echo htmlspecialchars($user['nid_birth']); ?>" required>
        </div>

        <div class="form-group">
          <label class="required">Date of Birth</label>
          <input type="date" name="dob" value="<?php echo $user['dob']; ?>" required>
        </div>

        <div class="form-group">
          <label class="required">Age</label>
          <input type="number" name="age" value="<?php echo $user['age']; ?>" min="10" max="100" required>
        </div>

        <!-- Gender -->
        <div class="form-group full-width">
          <label class="required">Gender</label>
          <div class="radio-group">
            <label>
              <input type="radio" name="gender" value="male" <?php echo ($user['gender'] == 'male') ? 'checked' : ''; ?> required> 
              👨 Male
            </label>
            <label>
              <input type="radio" name="gender" value="female" <?php echo ($user['gender'] == 'female') ? 'checked' : ''; ?>> 
              👩 Female
            </label>
            <label>
              <input type="radio" name="gender" value="other" <?php echo ($user['gender'] == 'other') ? 'checked' : ''; ?>> 
              👥 Other
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="required">Marital Status</label>
          <select name="marital_status" required>
            <option value="">-- Select Status --</option>
            <option value="single" <?php echo ($user['marital_status'] == 'single') ? 'selected' : ''; ?>>Single</option>
            <option value="married" <?php echo ($user['marital_status'] == 'married') ? 'selected' : ''; ?>>Married</option>
            <option value="divorced" <?php echo ($user['marital_status'] == 'divorced') ? 'selected' : ''; ?>>Divorced</option>
          </select>
        </div>

        <div class="form-group">
          <label class="required">Blood Group</label>
          <select name="blood_group" required>
            <option value="">-- Select Blood Group --</option>
            <option <?php echo ($user['blood_group'] == 'A+') ? 'selected' : ''; ?>>A+</option>
            <option <?php echo ($user['blood_group'] == 'A-') ? 'selected' : ''; ?>>A-</option>
            <option <?php echo ($user['blood_group'] == 'B+') ? 'selected' : ''; ?>>B+</option>
            <option <?php echo ($user['blood_group'] == 'B-') ? 'selected' : ''; ?>>B-</option>
            <option <?php echo ($user['blood_group'] == 'O+') ? 'selected' : ''; ?>>O+</option>
            <option <?php echo ($user['blood_group'] == 'O-') ? 'selected' : ''; ?>>O-</option>
            <option <?php echo ($user['blood_group'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
            <option <?php echo ($user['blood_group'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
          </select>
        </div>

        <div class="form-group">
          <label class="required">Religion</label>
          <select name="religion" required>
            <option value="">-- Select Religion --</option>
            <option value="islam" <?php echo ($user['religion'] == 'islam') ? 'selected' : ''; ?>>Islam</option>
            <option value="hindu" <?php echo ($user['religion'] == 'hindu') ? 'selected' : ''; ?>>Hindu</option>
            <option value="buddhist" <?php echo ($user['religion'] == 'buddhist') ? 'selected' : ''; ?>>Buddhist</option>
            <option value="christian" <?php echo ($user['religion'] == 'christian') ? 'selected' : ''; ?>>Christian</option>
            <option value="other" <?php echo ($user['religion'] == 'other') ? 'selected' : ''; ?>>Other</option>
          </select>
        </div>

        <div class="section-title">Contact Information</div>

        <!-- Contact Info -->
        <div class="form-group">
          <label class="required">Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
          <label class="required">Phone Number</label>
          <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="section-title">Address Information</div>

        <!-- Address -->
        <div class="form-group">
          <label class="required">District</label>
          <select name="district" required>
            <option value="">-- Select District --</option>
            <option value="dhaka" <?php echo ($user['district'] == 'dhaka') ? 'selected' : ''; ?>>Dhaka</option>
            <option value="chattogram" <?php echo ($user['district'] == 'chattogram') ? 'selected' : ''; ?>>Chattogram</option>
            <option value="rajshahi" <?php echo ($user['district'] == 'rajshahi') ? 'selected' : ''; ?>>Rajshahi</option>
            <option value="khulna" <?php echo ($user['district'] == 'khulna') ? 'selected' : ''; ?>>Khulna</option>
            <option value="barisal" <?php echo ($user['district'] == 'barisal') ? 'selected' : ''; ?>>Barisal</option>
            <option value="sylhet" <?php echo ($user['district'] == 'sylhet') ? 'selected' : ''; ?>>Sylhet</option>
            <option value="rangpur" <?php echo ($user['district'] == 'rangpur') ? 'selected' : ''; ?>>Rangpur</option>
            <option value="mymensingh" <?php echo ($user['district'] == 'mymensingh') ? 'selected' : ''; ?>>Mymensingh</option>
          </select>
        </div>

        <div class="form-group">
          <label class="required">Upazila</label>
          <select name="upazila" required>
            <option value="">-- Select Upazila --</option>
            <!-- Dhaka District -->
            <optgroup label="Dhaka">
              <option value="savar" <?php echo ($user['upazila'] == 'savar') ? 'selected' : ''; ?>>Savar</option>
              <option value="uttara" <?php echo ($user['upazila'] == 'uttara') ? 'selected' : ''; ?>>Uttara</option>
              <option value="dhanmondi" <?php echo ($user['upazila'] == 'dhanmondi') ? 'selected' : ''; ?>>Dhanmondi</option>
              <option value="mirpur" <?php echo ($user['upazila'] == 'mirpur') ? 'selected' : ''; ?>>Mirpur</option>
              <option value="keraniganj" <?php echo ($user['upazila'] == 'keraniganj') ? 'selected' : ''; ?>>Keraniganj</option>
            </optgroup>
            
            <!-- Narayanganj District -->
            <optgroup label="Narayanganj">
              <option value="sonargaon" <?php echo ($user['upazila'] == 'sonargaon') ? 'selected' : ''; ?>>Sonargaon</option>
              <option value="narayanganj-sadar" <?php echo ($user['upazila'] == 'narayanganj-sadar') ? 'selected' : ''; ?>>Narayanganj Sadar</option>
              <option value="bandar" <?php echo ($user['upazila'] == 'bandar') ? 'selected' : ''; ?>>Bandar</option>
              <option value="rupganj" <?php echo ($user['upazila'] == 'rupganj') ? 'selected' : ''; ?>>Rupganj</option>
            </optgroup>
            
            <!-- Gazipur District -->
            <optgroup label="Gazipur">
              <option value="gazipur-sadar" <?php echo ($user['upazila'] == 'gazipur-sadar') ? 'selected' : ''; ?>>Gazipur Sadar</option>
              <option value="tongi" <?php echo ($user['upazila'] == 'tongi') ? 'selected' : ''; ?>>Tongi</option>
              <option value="kaliakoir" <?php echo ($user['upazila'] == 'kaliakoir') ? 'selected' : ''; ?>>Kaliakoir</option>
              <option value="kapasia" <?php echo ($user['upazila'] == 'kapasia') ? 'selected' : ''; ?>>Kapasia</option>
            </optgroup>
          </select>
        </div>

        <div class="form-group full-width">
          <label>Address</label>
          <textarea name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>

        <div class="section-title">Education & Profession</div>

        <!-- Education & Work -->
        <div class="form-group">
          <label class="required">Education Level</label>
          <select name="education" required>
            <option value="">-- Select Education --</option>
            <option value="ssc" <?php echo ($user['education'] == 'ssc') ? 'selected' : ''; ?>>SSC</option>
            <option value="hsc" <?php echo ($user['education'] == 'hsc') ? 'selected' : ''; ?>>HSC</option>
            <option value="bachelor" <?php echo ($user['education'] == 'bachelor') ? 'selected' : ''; ?>>Bachelor</option>
            <option value="masters" <?php echo ($user['education'] == 'masters') ? 'selected' : ''; ?>>Masters</option>
            <option value="phd" <?php echo ($user['education'] == 'phd') ? 'selected' : ''; ?>>PhD</option>
          </select>
        </div>

        <div class="form-group">
          <label>Profession</label>
          <input type="text" name="profession" value="<?php echo htmlspecialchars($user['profession']); ?>">
        </div>

        <!-- Enhanced Button Group -->
        <div class="form-group full-width">
          <div class="button-group">
            <a href="dashboard.php" class="cancel-btn">
              ❌ Cancel
            </a>
            <button type="submit" class="submit-btn">
              ✅ Update User
            </button>
          </div>
        </div>
      </div>
    </form>
    <?php else: ?>
    <div class="message error">
      User not found.
    </div>
    <div style="text-align: center; margin-top: 20px;">
      <a href="dashboard.php" class="cancel-btn" style="display: inline-flex; width: auto; padding: 10px 20px;">
        🔙 Back to Dashboard
      </a>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>
<?php
// Close connection
if (isset($conn)) {
    $conn->close();
}
?>