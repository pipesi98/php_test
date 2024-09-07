<?php
class Validator {
    public static function validateTaskData($data) {
        $errors = [];
        if (empty($data['title'])) {
            $errors[] = 'Title is required';
        }
        if (empty($data['description'])) {
            $errors[] = 'Description is required';
        }
        if (!in_array($data['status'], ['pending', 'completed'])) {
            $errors[] = 'Invalid status';
        }
        return $errors;
    }
}
?>
