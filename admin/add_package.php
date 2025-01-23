<?php
session_start();
include 'controls/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Start transaction
        $conn->begin_transaction();

        // Handle main package image upload
        if(isset($_FILES['package_image']) && $_FILES['package_image']['error'] == 0) {
            $main_image_name = "package_" . time() . ".jpg";
            $main_image_path = "../images/" . $main_image_name;
            $db_image_path = "images/" . $main_image_name;
            
            if(!move_uploaded_file($_FILES['package_image']['tmp_name'], $main_image_path)) {
                throw new Exception("Error uploading main package image");
            }
        } else {
            throw new Exception("No main package image uploaded");
        }

        // Insert into packages table
        $stmt = $conn->prepare("INSERT INTO packages (image_name_location, price, package_name, description, product_used, duration) VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sdsssi", 
            $db_image_path,
            $_POST['price'],
            $_POST['package_name'],
            $_POST['description'],
            implode('/', $_POST['products']), // Store product IDs as forward-slash separated string
            $_POST['duration']
        );
        
        if ($stmt->execute()) {
            $package_id = $conn->insert_id;
            
            // Handle additional images upload
            if(isset($_FILES['additional_images'])) {
                $stmt3 = $conn->prepare("INSERT INTO package_images (package_id, image_path) VALUES (?, ?)");
                
                foreach($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
                    if($_FILES['additional_images']['error'][$key] == 0) {
                        $additional_image_name = "package_" . $package_id . "_" . time() . "_" . $key . ".jpg";
                        $additional_image_path = "../images/" . $additional_image_name;
                        $db_additional_path = "images/" . $additional_image_name;
                        
                        if(move_uploaded_file($tmp_name, $additional_image_path)) {
                            $stmt3->bind_param("is", $package_id, $db_additional_path);
                            $stmt3->execute();
                        }
                    }
                }
                if(isset($stmt3)) $stmt3->close();
            }
            
            // Insert each product association
            $stmt2 = $conn->prepare("INSERT INTO package_products (package_id, product_id, quantity_needed) VALUES (?, ?, ?)");
            
            for ($i = 0; $i < count($_POST['products']); $i++) {
                if (!empty($_POST['products'][$i]) && !empty($_POST['quantities'][$i])) {
                    $stmt2->bind_param("iii",
                        $package_id,
                        $_POST['products'][$i],
                        $_POST['quantities'][$i]
                    );
                    $stmt2->execute();
                }
            }
            
            // Commit transaction
            $conn->commit();
            $_SESSION['success_message'] = "Package created successfully!";
        } else {
            throw new Exception("Error creating package");
        }
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    // Close statements
    if (isset($stmt)) $stmt->close();
    if (isset($stmt2)) $stmt2->close();
    
    // Redirect back to inventory page
    header("Location: inventory.php");
    exit();
}
?>