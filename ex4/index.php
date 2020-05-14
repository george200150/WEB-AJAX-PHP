<?php

// verificam daca e gata jocul
function is_valid($matrix) {
	$ok = false; // ok e break condition-ul, e setat True cand cineva a completat o linie pe tabla
	for ($i = 0; $i < 3 && !$ok; $i++) {
		// linie completa
		if ($matrix[$i][0] == $matrix[$i][1] && $matrix[$i][1] == $matrix[$i][2] && $matrix[$i][2] != -1)
			$ok = true;
		// coloana completa
		if ($matrix[0][$i] == $matrix[1][$i] && $matrix[1][$i] == $matrix[2][$i] && $matrix[2][$i] != -1)
			$ok = true;
	}
	// una diagonale este completa
	if (!$ok && $matrix[0][0] != -1 && $matrix[0][0] == $matrix[1][1] && $matrix[1][1] == $matrix[2][2])
		$ok = true;
	if (!$ok && $matrix[2][0] != -1 && $matrix[2][0] == $matrix[1][1] && $matrix[1][1] == $matrix[0][2])
		$ok = true;
	return $ok; // $ok e inca false daca nu s-a terminat jocul
}


if (isset($_POST['data'])) { // verificam sa fi primit datele prin HTTP
	$data = json_decode($_POST['data'], true); // decodam datele formatate (.json)
	$table = $data['matrix'];
	$valid = is_valid($table); // verificam conditiile de terminare a jocului

	if ($valid) // a castigat userul
		echo json_encode(array("positions" => array(), "valid" => 1)); // 1 means WIN
	else { // altfel, poate fi remiza, pierdere sau inca se joaca.
		$positions = array(); // 
		for ($i = 0; $i < 3; $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($table[$i][$j] == -1) // inseram in $positions numai acele tile-uri ramase libere pe tabla
					array_push($positions, array($i, $j));
			}
		}
		// remiza
		if (count($positions) == 0) // daca niciunul nu a castigat si nu mai exista pozitii
			echo json_encode(array("positions" => array(), "valid" => 3)); // 3 means DRAW
		else {

			$index = $positions[rand(0, count($positions) - 1)]; // calculatorul completeaza radom o pozitie in tabla
			$table[$index[0]][$index[1]] = $data['current'];
			$valid = is_valid($table); // verificam iar starea jocului

			// a castigat calculatorul
			if ($valid) // in conditiile in care computerul a facut ultima mutare, sigur userul nu putea castiga acum.
				echo json_encode(array("positions" => $index, "valid" => 2)); // 2 means LOSS
			elseif (count($positions) == 1)
				echo json_encode(array("positions" => $index, "valid" => 3)); // 3 means DRAW
			// se joaca
			else
				echo json_encode(array("positions" => $index, "valid" => 0)); // 0 means GAME ON
		}
	}
}
?>