<div id="search_area" class="col_12 column">
			<form class="horizontal" method="post" action="<?php echo $this->webroot; ?>jobs/browse">
				<input name="keywords" id="keywords" type="text" placeholder="Enter Keywords..." /> 
				<select name="state" id="state_select">
					<option>Select Region</option>
					<option value="DO">Dolnośląskie</option>
					<option value="KP">Kujawsko-pomorskie</option>
					<option value="LU">Lubelskie</option>
					<option value="LS">Lubuskie</option>
					<option value="LO">Łódzkie</option>
					<option value="MA">Małopolskie</option>
					<option value="MZ">Mazowieckie</option>
					<option value="OP">Opolskie</option>
					<option value="PO">Podkarpackie</option>
					<option value="PD">Podlaskie</option>
					<option value="PM">Pomorskie</option>
					<option value="SL">Śląskie</option>
					<option value="SW">Świętokrzyskie</option>
					<option value="WM">Warmińsko-Mazurskie</option>
					<option value="WK">Wielkopolskie</option>
					<option value="ZM">Zachodniopomorskie</option> 
				</select>
				<select id="category_select" name="category">
					<option>Select Category</option>
					<?php foreach($categories as $category) : ?>
						<option value="<?php echo $category['Category']['id']; ?>"><?php echo $category['Category']['name']; ?></option>
					<?php endforeach; ?>
			</select>
				<button type="submit">Submit</button>
			</form>
		</div>


