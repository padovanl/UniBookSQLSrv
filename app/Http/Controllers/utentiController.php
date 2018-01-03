<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class utentiController extends Controller {

	public function registrazione() {

		if (isset($_GET["idusername"]) && $_GET["idusername"] != "")
			$insert["email"] = $_GET["idusername"];
		else
			return "Inserisci un'e-mail!";

		if (isset($_GET["password"]) && $_GET["password"] != "")
			$insert["Password"] = $_GET["password"];
		else
			return "Inserisci una password!";

		if (isset($_GET["idcitta"]) && $_GET["idcitta"] != "")
			$insert["Citta"] = $_GET["idcitta"];

		if (isset($_GET["idnome"]) && $_GET["idnome"] != "")
			$insert["Nome"] = $_GET["idnome"];

		if (isset($_GET["idcognome"]) && $_GET["idcognome"] != "")
			$insert["Cognome"] = $_GET["idcognome"];

		if (isset($_GET["iddatepicker"]) && $_GET["iddatepicker"] != "")
			$insert["Data_Nascita"] = $_GET["iddatepicker"];

		if (isset($_GET["tipo"]) && $_GET["tipo"] != "")
			$insert["Tipo"] = $_GET["tipo"];
		$result = DB::table("Utente")->insert($insert);

		return "Dati registrati con successo!";
	}

	public function modifica() {

		if (!(isset($_GET["idutente"]) && $_GET["idutente"] != ""))
			return "Inserisci l'id dell'utente!";
		else
			$idutente = $_GET['idutente'];

		if (isset($_GET["idcitta"]) && $_GET["idcitta"] != "")
			$update["Citta"] = $_GET["idcitta"];

			if (isset($_GET["idnome"]) && $_GET["idnome"] != "")
			$update["Nome"] = $_GET["idnome"];

		if (isset($_GET["idcognome"]) && $_GET["idcognome"] != "")
			$update["Cognome"] = $_GET["idcognome"];

		if (isset($_GET["idusername"]) && $_GET["idusername"] != "")
			$update["email"] = $_GET["idusername"];

		if (isset($_GET["iddatepicker"]) && $_GET["iddatepicker"] != "")
			$update["Data_Nascita"] = $_GET["iddatepicker"];

		if (isset($_GET["tipo"]) && $_GET["tipo"] != "")
			$update["Tipo"] = $_GET["tipo"];

		if (isset($_GET["password"]) && $_GET["password"] != "")
			$update["Password"] = $_GET["password"];

		$result = DB::table("Utente")->where("ID", $idutente)->update($update);

		return "Dati modificati con successo!";
	}

	public function cancella_utente(Request $request) {
		$id = $request->input("id");
			$del_like = DB::table("like_commento")->where("id_utente", $utente->ID)->delete();
		$del_commento = DB::table("commento")->where("id_autore", $utente->ID)->delete();
$del_like1 = DB::table("like_post")->where("id_utente", $utente->ID)->delete();
$del_notify = DB::table("notifica")->where("id_utente", $utente->ID)->delete();

$del_like = DB::table("like_commento")->where("id_utente", $utente->ID)->delete();
$del_post = DB::table("post")->where("id_utente", $utente->ID)->delete();
$del_amicizia = DB::table("utente_stringe_amicizia")->where("id_utente", $utente->ID)->delete();
$del_amicizia = DB::table("utente_segue_pagina")->where("id_utente", $utente->ID)->delete();
		$del_pagina = DB::table("pagina")->where("id_proprietario", $utente->ID)->delete();

		$del_user = DB::table("Utente")->where("ID", $id)->delete();

		return "Utente eliminato con successo!";
	}
}
?>
