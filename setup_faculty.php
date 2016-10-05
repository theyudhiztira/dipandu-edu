<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_check(1);
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu Smart > Setup Faculty : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3D5AFE;" onload="loadData()">
        <?php
        echo navigation_bar();
        ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <a onclick="openFile('admin')" style="color: #FFF;"><b><i class="fa fa-caret-left"></i> Back To Home</b></a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <div class="col s12 m12 l12 advanced-search-box" style="padding: 0px !important;">
                    <div class="col s12 m12 l12" style="background-color: #FF9800; color: #FFF; border-radius: 2.5px;">
                        <h5>Faculty Setup</h5>
                    </div>
                    <div class="col s12 m12 l12" style="margin-top: 10px;">
                        <div class="col s12 m6 l6 input-field">
                            <input type="text" id="short_name">
                            <label>Short Name</label>
                        </div>   
                        <div class="col s12 m6 l6 input-field">
                            <input type="text" id="full_name">
                            <label>Display Name</label>
                        </div> 
                        <div class="col s12 m6 l6 input-field" style="margin-bottom: 20px;">
                            <button id="addBtn" style="display: inline-block;" class="btn" onclick="addData()">Add</button>
                            <button id="saveBtn" style="display: none;" class="btn">Save</button>
                            <button id="cancelBtn" onclick="emptyField()" style="display: none;" class="btn">Cancel</button>
                        </div> 
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <table class="striped">
                    <thead class="table-head">
                        <tr>
                            <td style="max-width: 482px !important;">No.</td>
                            <td>Short Name</td>
                            <td>Full Name</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="faculty-table">
                    </tbody>
                    <tfoot id="e-library-table-foot">
                        <tr>
                            <td colspan="4" class="center-align center">
                                <ul class="pagination" id="pageDisplay">
                                    <?php
                                        echo $pagination;
                                    ?>
                                </ul>
                            </td>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>
        </div>
    <?php
    echo javaScriptCall();
    ?>
    <script type='text/javascript' src='js/main-local.js'></script>  
    <script type='text/javascript' src='js/setup_faculty.js'></script>  
    </body>
</html>
