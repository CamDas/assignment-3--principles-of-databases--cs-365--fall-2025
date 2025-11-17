<?php

function printAttributesFromTable($attribute, $table)
{
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER);

        $statement = $db->prepare("SELECT $attribute FROM $table");
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_NUM)) {
            echo "<li>$row[0]</li>\n";
        }

        $statement = null;
    } catch (PDOException $error) {
        echo "<p class='highlight'>The function " .
            "<code>printAttributesFromTable</code> has generated the " .
            "following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit();
    }
}

function updateAttribute(
    $table,
    $current_attribute,
    $new_attribute,
    $query_attribute,
    $pattern
) {
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=" . DBHOST . "; dbname=" . DBNAME, DBUSER);

        $statement = $db->prepare(
            "UPDATE $table " .
                "SET $current_attribute = :new_attribute " .
                "WHERE $query_attribute = :pattern"
        );

        $statement->execute([
            "new_attribute" => $new_attribute,
            "pattern" => $pattern,
        ]);

        $statement = null;
    } catch (PDOException $error) {
        echo "<p class='highlight'>The function <code>updateAttribute</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit();
    }
}

function newUser($user_id, $first_name, $last_name, $email)
{
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=" . DBHOST . "; dbname=" . DBNAME, DBUSER);

        $statement = $db->prepare(
            "INSERT INTO user (user_id, first_name, last_name, email) " .
                "VALUES (:user_id, :first_name, :last_name, :email) " .
                "ON DUPLICATE KEY UPDATE first_name = VALUES(first_name), last_name = VALUES(last_name), email = VALUES(email)" //even when an id isn't used, it always throws an error without this
        );
        $statement->execute([
            "user_id" => $user_id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
        ]);
        $statement = null;
    } catch (PDOException $error) {
        echo "<p class='highlight'>The function <code>newUser</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit();
    }
}

function newWebsite($site_id, $site_name, $domain)
{
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=" . DBHOST . "; dbname=" . DBNAME, DBUSER);

        $statement = $db->prepare(
            "INSERT INTO website (site_id, site_name, domain)" .
                "VALUES (:site_id, :site_name, :domain)" .
                "ON DUPLICATE KEY UPDATE site_name = VALUES(site_name), domain = VALUES(domain)"
        );
        $statement->execute([
            "site_id" => $site_id,
            "site_name" => $site_name,
            "domain" => $domain,
        ]);
        $statement = null;
    } catch (PDOException $error) {
        echo "<p class='highlight'>The function <code>newWebsite</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit();
    }
}

function newAccount(
    $username,
    $password,
    $site_id,
    $user_id,
    $comment,
    $time_created
) {
    try {
        include_once "config.php";
        $db = new PDO("mysql:host=" . DBHOST . "; dbname=" . DBNAME, DBUSER);

        $set_encryption_mode_query =
            "SET block_encryption_mode = 'aes-256-cbc';";
        $statement = $db->prepare($set_encryption_mode_query);
        $statement->execute();
        $key_str = defined("KEY_STR") ? KEY_STR : "who goes there";
        $init_vector = defined("INIT_VECTOR")
            ? INIT_VECTOR
            : "your_init_vector";

        $statement = $db->prepare(
            "INSERT INTO password (username, password, user_id, site_id, comment, time_created) " .
                "VALUES (:username, AES_ENCRYPT(:password, :key_str, :init_vector), :user_id, :site_id, :comment, :time_created)" .
                "ON DUPLICATE KEY UPDATE username = VALUES(username), password = VALUES(password), comment = VALUES(comment), time_created = VALUES(time_created)"
        );
        $statement->execute([
            "username" => $username,
            "password" => $password,
            "key_str" => $key_str,
            "init_vector" => $init_vector,
            "user_id" => $user_id,
            "site_id" => $site_id,
            "comment" => $comment,
            "time_created" => date("Y-m-d H:i:s"),
        ]);
        $statement = null;
    } catch (PDOException $error) {
        echo "<p class='highlight'>The function <code>newAccount</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";
        exit();
    }
}

function delete($table, $attribute, $query)
{
    try {
        include_once "config.php";

        $db = new PDO("mysql:host=" . DBHOST . "; dbname=" . DBNAME, DBUSER);

        $statement = $db->prepare(
            "DELETE FROM $table WHERE $attribute = :query"
        );
        $statement->execute(["query" => $query]);
        $statement = null;
    } catch (PDOException $error) {
        echo "<p class='highlight'>The function <code>delete</code> " .
            "has generated the following error:</p>" .
            "<pre>$error</pre>" .
            "<p class='highlight'>Exiting…</p>";

        exit();
    }
}
