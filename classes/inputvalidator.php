<?php

/**
 * InputValidator Class
 *
 * This class contains methods for validating various types of user input.
 */
class InputValidator
{
    /**
     * Cleans a string by removing HTML and PHP tags and converting special characters to HTML entities.
     *
     * @param string $input The string to be cleaned.
     *
     * @return string The cleaned string.
     */
    function cleanString($input)
    {
        // Remove any HTML or PHP tags
        $cleaned = strip_tags($input);

        // Convert special characters to HTML entities
        $cleaned = htmlspecialchars($cleaned, ENT_QUOTES, 'UTF-8');

        return $cleaned;
    }

    /**
     * Validates a name input.
     *
     * This function checks if the input is a valid name. A valid name can only contain letters, dashes, and spaces.
     *
     * @param string $name The name to be validated.
     *
     * @return bool Returns true if the name is valid, false otherwise.
     */
    function nameValidator($name)
    {
        // Check if the input is a valid name
        // A valid name can only contain letters, dashes, and spaces
        if (preg_match('/^[\p{L}\s-]+$/u', $name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validates an email address.
     *
     * This function checks if the input is a valid email address using the filter_var function.
     *
     * @param string $email The email address to be validated.
     *
     * @return bool Returns true if the email address is valid, false otherwise.
     */
    function emailValidation($email)
    {
        // Use the filter_var function to validate the email address
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validates a password.
     *
     * This function checks if the input is a valid password. A valid password must contain at least one uppercase letter, two digits, one special character, and be at least 9 characters long.
     *
     * @param string $password The password to be validated.
     *
     * @return bool Returns true if the password is valid, false otherwise.
     */
    function passwordValidation($password)
    {
        // Check if the input is a valid password
        // A valid password must contain at least one uppercase letter, two digits, one special character, and be at least 9 characters long
        if (preg_match('/^(?=.*[A-ZÆØÅ])(?=.*\d{2,})(?=.*[^a-zA-ZÆØÅæøå\d]).{9,}$/', $password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Cleans a name string.
     *
     * This function takes a name as input, cleans it by removing any HTML and PHP tags and converting special characters to HTML entities, and then converts it to title case (the first letter of each word is capitalized, and all other letters are lowercase).
     *
     * @param string $name The name to be cleaned.
     *
     * @return string The cleaned name.
     */
    function cleanName($name)
    {
        // Clean the string
        $cleaned = $this->cleanString($name);
        // Convert the cleaned string to title case
        $cleanedName = ucwords(strtolower(($cleaned)));

        return $cleanedName;
    }
}
