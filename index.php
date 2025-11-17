    <?php require "includes/helpers.php"; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Made by: Cameron DaSilva</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500&family=IBM+Plex+Sans:ital,wght@100;200;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h1>Password Book<br>(Working with a <abbr title="Any OS, Apache, MySQL, and PHP">XAMP</abbr> Stack Using a Password Database)</h1>
  </header>
  <main>

    <form id="clear-results" method="post"
            action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input id="clear-form-button" type="submit" value="Clear All Results">
    </form>

    <section>
        <fieldset>
    <h2>Search Attributes</h2>
    <hr>
    <form method="post" action="">
        <label for="table">Table:</label>
        <input type="text" id="table" name="table" value="">

        <label for="attribute">Attribute:</label>
        <input type="text" id="attribute" name="attribute" value="">

        <button type="submit" name="searchSubmit">Search</button>
    </form>

    <p><strong class="database-result"></strong></p>
    <?php if (isset($_POST["searchSubmit"])) {
        $table = $_POST["table"] ?? "";
        $attribute = $_POST["attribute"] ?? "";

        if ($table === "" || $attribute === "") {
            echo "Please enter both table and attribute.";
        } else {
            printAttributesFromTable($attribute, $table);
        }
    } else {
        echo "No search requested.";
    } ?>
</section>
</fieldset>

    <section>
        <fieldset>
        <h2>Update any Value</h2>
        <hr>
        <form method="post" action="">
            <label for="table">Table:</label>
            <input type="text" id="table" name="table" value="">

            <label for="current_attribute">Attribute selection:</label>
            <input type="text" id="current_attribute" name="current_attribute" value="">

            <label for="new_attribute">New value:</label>
            <input type="text" id="new_attribute" name="new_attribute" value="">

            <label for="pattern">Old value (to update):</label>
            <input type="text" id="pattern" name="pattern" value="">

            <button type="submit" name="updateSubmit">Update</button>
        </form>

        <p><strong class="database-result"></strong>
        <?php if (isset($_POST["updateSubmit"])) {
            $table = $_POST["table"] ?? "";
            $current_attribute = $_POST["current_attribute"] ?? "";
            $new_attribute = $_POST["new_attribute"] ?? "";
            $query_attribute = $_POST["current_attribute"] ?? "";
            $pattern = $_POST["pattern"] ?? "";

            if (
                $table === "" ||
                $current_attribute === "" ||
                $new_attribute === ""
            ) {
                echo "Please fill in all required fields.";
            } else {
                updateAttribute(
                    $table,
                    $current_attribute,
                    $new_attribute,
                    $query_attribute,
                    $pattern
                );
                printAttributesFromTable($current_attribute, $table);
            }
        } else {
            echo "No update requested.";
        } ?>
        </p>
    </section>
    </fieldset>

    <section>
        <fieldset>
<form id="insert-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <h2>Add a New User</h2>
        <hr>

            <label for="userID">User ID:</label>
            <input type="text" name="userID" value="">

            <label for="userFirstName">First Name:</label>
            <input type="text" name="userFirstName" value="">

            <label for="userLastName">Last Name:</label>
            <input type="text" name="userLastName" value="">


            <label for="userEmail">Email Address:</label>
            <input type="text" name="userEmail" value="">

            <button type="submit" name="newUserButton">Add</button>
        </form>

       <p><strong class="database-result"></strong>
        <?php if (isset($_POST["newUserButton"])) {
            $user_id = $_POST["userID"] ?? "";
            $first_name = $_POST["userFirstName"] ?? "";
            $last_name = $_POST["userLastName"] ?? "";
            $email = $_POST["userEmail"] ?? "";

            if (
                $user_id === "" ||
                $first_name === "" ||
                $last_name === "" ||
                $email === ""
            ) {
            } else {
                newUser(
                    $user_id,
                    $first_name,
                    $last_name,
                    $email
                );
                newUser($user_id, $first_name, $last_name, $email);
            }
        } else {
            echo "No additonal user created.";
        } ?>
        </p>
    </section>
    </fieldset>

    <section>
        <fieldset>
<form id="insert-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<h2>Add a New Website</h2>
        <hr>

            <label for="siteID">Site ID:</label>
            <input type="text" name="siteID" value="">

            <label for="siteName">Site Name:</label>
            <input type="text" name="siteName" value="">


            <label for="newDomain">Website Domain:</label>
            <input type="text" name="newDomain" value="">

            <button type="submit" name="newUserButton">Add</button>
        </form>

       <p><strong class="database-result"></strong>
        <?php if (isset($_POST["newUserButton"])) {
            $site_id = $_POST["siteID"] ?? "";
            $site_name = $_POST["siteName"] ?? "";
            $domain = $_POST["newDomain"] ?? "";

            if (
                $site_id === "" ||
                $site_name === "" ||
                $domain === ""
            ) {
            } else {
                newWebsite(
                    $site_id,
                    $site_name,
                    $domain
                );
                newWebsite($site_id, $site_name, $domain);
            }
        } else {
            echo "No additonal website added.";
        } ?>
        </p>
    </section>
    </fieldset>

        <section>
        <fieldset>
<form id="insert-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<h2>Add a New Account</h2>
    <hr>

        <label for="newUsername">Username:</label>
        <input type="text" name="newUsername" value="">

        <label for="newPassword">Password:</label>
        <input type="text" name="newPassword" value="">

        <label for="siteID">Site ID:</label>
        <input type="text" name="siteID" value="">

        <label for="userID">User ID:</label>
        <input type="text" name="userID" value="">

        <label for="comment">Comment:</label>
        <input type="text" name="comment" value="">

        <!-- capture current time when form is rendered -->
        <input type="hidden" name="time_created" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <button type="submit" name="newAccountButton">Add</button>
    </form>

       <p><strong class="database-result"></strong>
    <?php if (isset($_POST["newAccountButton"])) {
        $username = $_POST["newUsername"] ?? "";
        $password = $_POST["newPassword"] ?? "";
        $site_id = $_POST["siteID"] ?? "";
        $user_id = $_POST["userID"] ?? "";
        $comment = $_POST["comment"] ?? "";
        $time_created = $_POST["time_created"] ?? date('Y-m-d H:i:s');

        if (
        $username === "" ||
        $password === "" ||
        $site_id === "" ||
        $user_id === ""
        ) {
        } else {
        newAccount(
            $username,
            $password,
            $site_id,
            $user_id,
            $comment,
            $time_created
        );
        newAccount($username, $password, $site_id, $user_id, $comment, $time_created);
        }
    } else {
        echo "No additonal account created.";
    } ?>
    </p>
    </section>
    </fieldset>

    <section>
    <fieldset>

<h2>Delete a Value</h2>
    <hr>
    <form method="post" action="">
        <label for="table">Table:</label>
        <input type="text" id="table" name="table" value="">

        <label for="attribute">Attribute selection:</label>
        <input type="text" id="attribute" name="attribute" value="">

        <label for="query">Value to delete (based on query):</label>
        <input type="text" id="query" name="query" value="">

        <button type="submit" name="deleteSubmit">Delete</button>
    </form>

    <p><strong class="database-result"></strong>
    <?php if (isset($_POST["deleteSubmit"])) {
        $table = ($_POST["table"] ?? "");
        $attribute = ($_POST["attribute"] ?? "");
        $query = ($_POST["query"] ?? "");

        if ($table === "" || $attribute === "") {
            echo "Please fill in all required fields.";
        } else {
            delete($table, $attribute, $query);

            echo "Record deleted. New List:<br>";
            printAttributesFromTable($attribute, $table);
        }
    } else {
        echo "No delete requested.";
    } ?>
    </p>
</fieldset>
    </section>
    </main>
</body>
</html>
