<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
    <dl>
        <dt><label for="username">Username:</label></dt>
        <dd><input type="text" name="username" value="" /></dd>
        
        <dt><label for="password">Password:</label></dt>
        <dd><input type="password" name="password" value="" /></dd>
        
        <dt></dt>
        <dd><input type="submit" value="Log In" /></dd>
    </dl>
</form>