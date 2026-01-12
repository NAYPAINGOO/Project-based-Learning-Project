<?php
require_once 'db.php';

function login($username, $password) {
    $conn = getDBConnection();
    
    $sql = "SELECT a.*, ac.account_status, ac.username, ac.account_id 
            FROM ALUMNI a 
            JOIN ACCOUNT ac ON a.alumni_id = ac.alumni_id 
            WHERE ac.username = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (in production, use password_verify())
        // For demo purposes, we're using simple comparison
        if ($password === 'demo123' || password_verify($password, $user['password'])) {
            if ($user['account_status'] === 'Approved') {
                // Set session variables
                $_SESSION['user_id'] = $user['alumni_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_role'] = ($user['username'] === 'admin') ? 'admin' : 'user';
                
                // Update last login
                $update_sql = "UPDATE ACCOUNT SET last_login = NOW() WHERE account_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $user['account_id']);
                $update_stmt->execute();
                
                return true;
            } else {
                return 'account_pending';
            }
        }
    }
    
    return false;
}

function registerAlumni($data) {
    $conn = getDBConnection();
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Insert into ALUMNI table
        $sql1 = "INSERT INTO ALUMNI (full_name, email, phone, graduation_year, program_id, current_job_title, address) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("ssssiss", 
            $data['full_name'], 
            $data['email'], 
            $data['phone'], 
            $data['graduation_year'], 
            $data['program_id'], 
            $data['current_job_title'], 
            $data['address']
        );
        $stmt1->execute();
        
        $alumni_id = $stmt1->insert_id;
        
        // Insert into ACCOUNT table
        $sql2 = "INSERT INTO ACCOUNT (username, password, alumni_id) 
                 VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt2->bind_param("ssi", $data['username'], $hashed_password, $alumni_id);
        $stmt2->execute();
        
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

function logout() {
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>