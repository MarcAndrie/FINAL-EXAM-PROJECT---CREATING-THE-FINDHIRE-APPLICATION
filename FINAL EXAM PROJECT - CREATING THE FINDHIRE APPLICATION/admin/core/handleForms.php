<?php
require_once 'models.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Handle job posting
        if (isset($_POST['add_job_post'])) {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);

            if (empty($title) || empty($description)) {
                throw new Exception("All fields are required.");
            }

            addJobPost($title, $description);
            header('Location: ../index.php?success=Job posted successfully.');
            exit();
        }

        // Handle application status update
        if (isset($_POST['update_status'])) {
            $applicationId = intval($_POST['application_id']);
            $status = $_POST['status'];

            if (!in_array($status, ['Accepted', 'Rejected'])) {
                throw new Exception("Invalid status.");
            }

            updateApplicationStatus($applicationId, $status);
            header('Location: ../manage_applications.php?success=Status updated successfully.');
            exit();
        }

        if (isset($_POST['edit_job_post'])) {
            $id = intval($_POST['id']);
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);

            if (empty($title) || empty($description)) {
                throw new Exception("All fields are required.");
            }

            updateJobPost($id, $title, $description);
            header('Location: ../index.php?success=Job post updated successfully.');
            exit();
        }
    } catch (Exception $e) {
        header('Location: ../error.php?error=' . urlencode($e->getMessage()));
        exit();
    }
}
?>
