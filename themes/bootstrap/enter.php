<?php include('layout/head.php');?>

                <h2>Enter to win</h2>
                <p>Enter your details and you would win the Internet</p>
                
                <?php if(!empty($messages)): ?>
                    <div class="alert alert-danger">
                        <p><strong>The following errors occurred:</strong></p>
                        <ul>
                            <?php foreach ($messages as $message): ?><li><?php echo $message; ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form role="form" id="enter" name="enter" method="post" action="<?php echo APP_PATH; ?>/enter">
                    
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input name="first_name" id="first_name" type="text" title="Please enter your first name"  class="form-control required" maxlength="50" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>" />
                    </div>
                    
                   <div class="form-group">
                        <label for="last_name" class="label_right">Last Name</label>
                        <input name="last_name" id="last_name" type="text" title="Please enter your last name" class="form-control equired" maxlength="50" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="text" title="Email required" class="form-control email required" maxlength="255" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="street">Address</label>
                        <input name="street" id="street" type="text" title="Please enter your street name" class="form-control required" maxlength="100" value="<?php echo isset($_POST['street']) ? $_POST['street'] : '' ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="suburb">Suburb/Town</label>
                        <input name="suburb" id="suburb" type="text" title="Please enter your suburb/town" class="form-control required" maxlength="100" value="<?php echo isset($_POST['suburb']) ? $_POST['suburb'] : '' ?>" />
                    </div>
                    
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" id="state" title="Please enter your state" class="form-control required">
                            <option value="">Select...</option>
                            <option value="ACT" <?php echo (isset($_POST['state']) && $_POST['state'] == "ACT") ? 'selected' : ''; ?>>ACT</option>
                            <option value="NSW" <?php echo (isset($_POST['state']) && $_POST['state'] == "NSW") ? 'selected' : ''; ?>>NSW</option>
                            <option value="NT" <?php echo (isset($_POST['state']) && $_POST['state'] == "NT") ? 'selected' : ''; ?>>NT</option>
                            <option value="QLD" <?php echo (isset($_POST['state']) && $_POST['state'] == "QLD") ? 'selected' : ''; ?>>QLD</option>
                            <option value="SA" <?php echo (isset($_POST['state']) && $_POST['state'] == "SA") ? 'selected' : ''; ?>>SA</option>
                            <option value="TAS" <?php echo (isset($_POST['state']) && $_POST['state'] == "TAS") ? 'selected' : ''; ?>>TAS</option>
                            <option value="VIC" <?php echo (isset($_POST['state']) && $_POST['state'] == "VIC") ? 'selected' : ''; ?>>VIC</option>
                            <option value="WA" <?php echo (isset($_POST['state']) && $_POST['state'] == "WA") ? 'selected' : ''; ?>>WA</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input name="postcode" id="postcode" title="Please Enter your postcode" type="text" class="form-control required" maxlength="6" value="<?php echo isset($_POST['postcode']) ? $_POST['postcode'] : '' ?>" />
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="terms" name="terms" value="1" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?> /> 
                            I have read and agree to the <a href="<?php echo APP_PATH; ?>/terms">Terms And Conditions</a> and the <a href="<?php echo APP_PATH; ?>/privacy">Privacy Policy</a>.
                        </label>                
                    </div>
                    
                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                    <input name="submit" type="submit" class="btn btn-default btn-lg" value="Enter" />
                    
                </form>

<?php include('layout/foot.php');?>