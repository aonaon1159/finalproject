<form method="post" role="form">

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid text-right">
            <button name="saveBtn" class="btn btn-lg btn-success navbar-btn">
                <i class="fa fa-save"></i>
            </button>
            <a href="" class="btn btn-lg btn-warning navbar-btn">
                <i class="fa fa-remove"></i>
            </a>
        </div>
    </nav>

    <div class="container" style="margin-top: 80px;">
        <div class="row">
            <?php
            $sql = "
					select * 
					from province 
					order by convert(pvName using tis620) 
			";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $province = "<option value=''>- Select -</option>";
            if (mysqli_num_rows($rs)) {
                while ($ds = mysqli_fetch_assoc($rs)) {
                    $province .= "<option value='{$ds["pvID"]}'>{$ds["pvName"]}</option>";
                }
            }
            ?>
            <div class="form-group col-sm-2">
                <label>เลือกจังหวัด</label>
                <select name="pvID" id="pvID" class="form-control" required>
                    <?= $province ?>
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label>เลือกอำเภอ</label>
                <select id="ampID" name="ampID" class="form-control" required>
                </select>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#pvID").change(function () {
                    var id = $("option:selected", this).val();
                    if (id != "") {
                        $.post("index.php?ajax_getamphur",{pvID:id},function(data){
                            $("#ampID").html(data);
                        });
                    }
                });
            });
        </script>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <input
                        type="checkbox"
                        name="carType"
                        id="carType"
                        data-toggle="toggle"
                        data-on="รถบริษัท"
                        data-off="รถร่วม"
                        data-onstyle="success"
                        data-offstyle="danger"
                        data-size="large"
                        data-width="100%"
                        checked>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#carType').change(function () {
                    if ($(this).prop('checked')) {
                        $("#f1").collapse("show");
                        $("#f2").collapse("hide");

                        $("#fn, #ln, #bd").attr('disabled', false);
                        $("#fn, #ln, #bd").attr('required', true);

                        $("#bt, #em, #ch_no").attr('disabled', true);
                        $("#bt, #em, #ch_no").attr('required', false);
                        $("#bt, #em, #ch_no").removeAttr('required');
                    } else {
                        $("#f1").collapse("hide");
                        $("#f2").collapse("show");

                        $("#fn, #ln, #bd").attr('disabled', true);
                        $("#fn, #ln, #bd").attr('required', false);
                        $("#fn, #ln, #bd").removeAttr('required');

                        $("#bt, #em, #ch_no").attr('disabled', false);
                        $("#bt, #em, #ch_no").attr('required', true);
                    }
                });
            });
        </script>
        <div id="f1" class="row collapse in">
            <div class="form-group col-sm-2">
                <label>First Name</label>
                <input type="text"
                       name="fn"
                       id="fn"
                       placeholder="กรอกชื่อ"
                       class="form-control input-lg"
                       data-errormessage-value-missing="กรุณากรอกชื่อ"
                       required>
            </div>

            <div class="form-group col-sm-2">
                <label>Last Name</label>
                <input type="text"
                       name="ln"
                       id="ln"
                       placeholder="กรอกนามสกุล"
                       class="form-control input-lg"
                       data-errormessage-value-missing="กรุณากรอกนามสกุล"
                       required>
            </div>
            <?php
            $today = date("Y-m-d");
            $last3month = date('Y-m-d', strtotime("-90 days"));
            $tomorrow = date('Y-m-d', strtotime("+1 days"));
            ?>
            <div class="form-group col-sm-3">
                <label>Birth Date</label>
                <input type="date"
                       name="bd"
                       id="bd"
                       min="<?php echo $last3month; ?>"
                       max="<?php echo $tomorrow; ?>"
                       class="form-control input-lg"
                       data-errormessage-value-missing="กรุณากรอกวันเกิด"
                       required>
            </div>
        </div>
        <div id="f2" class="row collapse">
            <?php date_default_timezone_set("Asia/Bangkok"); ?>
            <div class="form-group col-sm-2">
                <label>Birth Time</label>
                <input type="time"
                       name="bt"
                       id="bt"
                       value="<?php echo date("H:i"); ?>"
                       class="form-control input-lg"
                       data-errormessage-value-missing="กรุณากรอกเวลาเกิด"
                       data-errormessage-range-overflow="เวลาเกินที่กำหนด"
                       data-errormessage-range-underflow="เวลาน้อยกว่าที่กำหนด"
                       required>
            </div>

            <div class="form-group col-sm-2">
                <label>Email</label>
                <input type="email"
                       name="em"
                       id="em"
                       class="form-control input-lg"
                       data-errormessage-value-missing="กรุณากรอกอีเมล"
                       required>
            </div>

            <div class="form-group col-sm-2">
                <label>Number of Child</label>
                <input type="number"
                       name="ch_no"
                       id="ch_no"
                       min="0"
                       max="5"
                       step="0.25"
                       class="form-control input-lg"
                       data-errormessage-value-missing="กรุณากรอกจำนวนบุตร"
                       required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-1">
                <button type="button" name="addTxtBox" id="addTxtBox" class="btn btn-block btn-info">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div id="part-list" class="row">

            <div class="col-sm-12 form-group">
                <input type="text"
                       name="sparePart[]"
                       class="form-control"
                       required>
            </div>

        </div>

        <script>
            $(document).ready(function () {
                var max_fields = 50; //maximum input boxes allowed
                var wrapper = $("#part-list"); //Fields wrapper
                var add_button = $("#addTxtBox"); //Add button ID

                var x = 1; //initlal text box count
                $(add_button).click(function (e) { //on add input button click
                    e.preventDefault();
                    if (x < max_fields) { //max input box allowed
                        x++; //text box increment
                        $(wrapper).append('<div class="col-sm-12 form-group"><input type="text" name="sparePart[]" class="form-control" required/><a href="#" id="removeTxt" class="btn btn-danger" style="position: absolute; z-index: 1; top: 0px; right: 15px;">x</a></div>'); //add input box
                    }
                });

                $(wrapper).on("click", "#removeTxt", function (e) { //user click on remove text
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                })

            });
        </script>


    </div>

    <div class="container">
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
            <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
        </ul>

        <div class="row">
            <div class="col-sm-12 text-right">
                <button name="saveBtn" class="btn btn-lg btn-success">
                    <i class="fa fa-check"></i> Save
                </button>
            </div>
        </div>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h3>HOME</h3>
                <p>Some content.</p>
            </div>
            <div id="menu1" class="tab-pane fade">
                <h3>Menu 1</h3>
                <p>Some content in menu 1.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Some content in menu 2.</p>
            </div>
        </div>

    </div>
    <?php
    if (isset($_POST["saveBtn"])) {
        $plateNo = mysqli_real_escape_string($conn, $_POST["PlateNumber"]);
        $platePrv = mysqli_real_escape_string($conn, $_POST["PlateProvince"]);
        $vNo = mysqli_real_escape_string($conn, $_POST["VehicleNumber"]);
        $brand = mysqli_real_escape_string($conn, $_POST["Brand"]);

        $sql = "
			INSERT av_vehicles SET
				PlateNumber = '{$plateNo}',
				PlateProvince = '{$platePrv}',
				VehicleNumber = '{$vNo}',
				Brand = '{$brand}'
	";

        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    ?>
    <table class="table table-bordered">
        <thead>
        <tr class="bg-primary">
            <th>1
            <th>2
            <th>3
            <th>4
            <th>5
        </thead>
        <tbody>
        <?php
        // Query data from table to show

        $sql = "select * from av_vehicles";
        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        if (mysqli_num_rows($rs)) {
        while ($ds = mysqli_fetch_assoc($rs)) {
        ?>
        <tr>
            <td><?php echo $ds[""]; ?>
            <td><?php echo $ds[""]; ?>
            <td><?php echo $ds[""]; ?>
            <td><?php echo $ds[""]; ?>
            <td><?php echo $ds[""]; ?>
                <?php
                }
                }
                ?>
        </tbody>
    </table>

</form>

<script>
    $(document).ready(function () {
        $("form").validate({
            focusInvalid: false,
            invalidHandler: function () {
                $(this).find(":input.error:first").focus();
            }
        });
    });
</script>
