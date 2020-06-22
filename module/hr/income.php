<form method="post" role="form">

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid text-right">
			<a class="navbar-brand text-white">ระบบเงินเดือน - รายได้</a>
			<button name="saveBtn" class="btn btn-lg btn-success navbar-btn">
				<i class="fa fa-save"></i>
			</button>
			<a href="./?mod=hr/salary" class="btn btn-lg btn-warning navbar-btn">
				<i class="fa fa-remove"></i>
			</a>
		</div>
	</nav>
	
	<div class="container" style="margin-top: 80px;">
	
			<div class="row"> 
					<div class="form-group col-lg-3">
					  <label>รหัสพนักงาน :</label>
						<input type="text" 
						name="ps_id" 
						placeholder="โชว์รหัสพนักงาน" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>คำนำหน้าชื่อ :</label>
						<input type="text" 
						name="prefix_name" 
						placeholder="โชว์คำนำหน้าชื่อ" 
						Class="form-control">
					</div>
						  
					<div class="form-group col-lg-3">
					  <label>ชื่อ :</label>
						<input type="text" 
						name="ps_name" 
						placeholder="โชว์ชื่อ" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>นามสกุล :</label>
						<input type="text" 
						name="ps_surname" 
						placeholder="โชว์นามสกุล" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>ตำแหน่ง :</label>
						<input type="text" 
						name="position_name" 
						placeholder="โชว์ตำแหน่ง" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>แผนก/ฝ่าย :</label>
						<input type="text" 
						name="section_name" 
						placeholder="โชว์แผนก/ฝ่าย" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>สาขา :</label>
						<input type="text" 
						name="branch_name" 
						placeholder="โชว์สาขา" 
						Class="form-control">
					</div>
			</div>
			
			<div class="row"> 
					<div class="form-group col-lg-3">
					  <label>สถานะ :</label>
						<input type="text" 
						name="ps_status" 
						placeholder="โชว์สถานะ" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>วันทำงาน :</label>
						<input type="text" 
						name="workday" 
						placeholder="โชว์จำนวนวันทำงาน" 
						Class="form-control">
					</div>
			</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h4>รายได้หลัก</h4>
											
					<table class="table table-bordered">
						<thead>
							<tr class="bg-success">
								<th class="text-center">ลำดับ</th>
								<th class="text-center">รายการ</th>
								<th class="text-center">จำนวนเงิน</th>								
						</thead>
			
						<tbody>
							<tr>
								<td>1
								<td>xxxxxxxxx
								<td>00,000
						</tbody>
					</table>
					
				</div>
				
				<div class="col-lg-6">
					<h4>รายได้รอง</h4>
					
					<table class="table table-bordered">
						<thead>
							<tr class="bg-success">
								<th class="text-center">ลำดับ</th>
								<th class="text-center">รายการ</th>
								<th class="text-center">จำนวนเงิน</th>								
						</thead>
			
						<tbody>
							<tr>
								<td>1
								<td>xxxxxxxxx
								<td>00,000
						</tbody>
					</table>
				  
				</div>
				
			</div>
		</div>		
	
		
	</div>
</form>