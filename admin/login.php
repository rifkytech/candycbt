<!DOCTYPE html>
<?php

// yang mau pasang di hosting,
// HILANGKAN TANDA KOMENTAR SETELAH BARIS Start sampai sebelum End
// Start =================>>>
// $_IP_SERVER = $_SERVER['SERVER_ADDR'];
// $_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
//
// if ($_IP_ADDRESS <> $_IP_SERVER) {
// 	header("Location: ../login.php");
// }
// End ===================<<<

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/config.candy.php");
$cekdb = mysqli_query($koneksi, "SELECT 1 FROM pengawas LIMIT 1");
if ($cekdb == false) {
	header("Location: ../install.php");
}

$ceks = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting"));

$namaaplikasi = $ceks['aplikasi'];
$namasekolah = $ceks['sekolah'];

if (isset($_POST['submit'])) {


	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = mysqli_query($koneksi, "SELECT * FROM pengawas WHERE username='$username'");

	$cek = mysqli_num_rows($query);
	$user = mysqli_fetch_array($query);


	if ($cek <> 0) {

		if ($user['level'] == 'admin') {

			if (!password_verify($password, $user['password'])) {
				$info = info("Password salah!", "NO");
			} else {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'admin';
				echo "<script>location.href = '.';</script>";
			}
		} elseif ($user['level'] == 'guru') {

			if ($password == $user['password']) {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'guru';
				echo "<script>location.href = '.';</script>";
			} else {
				$info = info("Password salah!", "NO");
			}
		}
	} elseif ($cek == 0 or $cekguru == 0) {
		echo "<script>alert('Pengguna tidak terdaftar');</script>";
	}
}

?>
<html lang="en">

<head>
	<title>Login Admin | <?= APLIKASI . " v" . VERSI . " r" . REVISI ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../dist/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../plugins/font-awesome/css/font-awesome.css">

	<link rel="stylesheet" type="text/css" href="../plugins/animate/animate.min.css">

	<link rel="stylesheet" type="text/css" href="../dist/bootstrap/css/util.css">
	<link rel="stylesheet" type="text/css" href="../dist/bootstrap/css/main.css">
	<style>
		.judul {
			position: absolute;
			right: 20px;
			top: 20px;
			z-index: 2;
			color: #000;
		}

		.logo {
			position: absolute;
			left: 20px;
			top: 20px;
			z-index: 2;
			color: #000;
			-webkit-filter: drop-shadow(5px 5px 5px #222);
			filter: drop-shadow(5px 5px 5px #222);

		}

		.wrap-login100-form-btn {
			display: block;
			position: relative;
			z-index: 1;
			border-radius: 0px;
			overflow: hidden;
		}
	</style>
</head>

<body style="background-color: #999999;">

	<div class="limiter">
		<div class="container-login100">
			<div class='judul'>&copy; <a href="http://candycbt.id" class="txt2 hov1">
					<b><?= APLIKASI . " v" . VERSI . " r" . REVISI ?></b>
				</a>
			</div>
			<div class='logo hidden-xs'>
				<svg x="0px" y="0px" viewBox="0 0 256 256" style="enable-background:new 0 0 256 256;" width="150px">
					<g transform="matrix(0.63517988,0,0,0.63738861,0.68930072,0.12227218)" id="svgg">
						<path id="path0" d="m 186.6,76.444 c -11.04,1.462 -25.09,4.839 -31.2,7.501 -0.765,0.333 -1.945,0.824 -3.9,1.623 -1.965,0.803 -11.384,5.439 -12.7,6.251 -5.892,3.636 -8.648,5.424 -11.6,7.525 -1.87,1.33 -3.49,2.523 -3.6,2.651 -0.11,0.128 -0.74,0.647 -1.4,1.153 -5.465,4.193 -14.859,13.587 -19.052,19.052 -0.506,0.66 -1.025,1.29 -1.153,1.4 -0.128,0.11 -1.321,1.73 -2.651,3.6 -2.101,2.952 -3.889,5.708 -7.525,11.6 -0.475,0.77 -1.993,3.74 -3.373,6.6 -2.451,5.077 -2.991,6.258 -3.7,8.1 -0.19,0.495 -0.526,1.305 -0.746,1.8 -3.394,7.645 -7.002,23.968 -7.803,35.3 l -0.226,3.2 1.541,-4.2 c 12.464,-33.955 37.84,-62.142 65.588,-72.853 0.495,-0.191 1.305,-0.517 1.8,-0.726 4.492,-1.889 12.618,-4.101 20.5,-5.581 40.195,-7.547 86.629,16.198 101.998,52.16 0.376,0.88 0.836,1.96 1.023,2.4 4.588,10.826 5.918,28.272 3.124,41 -0.73,3.322 -2.264,8.518 -3.13,10.6 -1.957,4.701 -3.319,7.469 -5.585,11.349 -14.552,24.917 -43.744,36.379 -67.43,26.476 -25.901,-10.828 -36.305,-34.43 -25.027,-56.772 5.844,-11.576 20.68,-19.264 31.067,-16.1 0.638,0.195 1.97,0.592 2.96,0.884 6.743,1.988 13.07,7.971 15.16,14.337 4.978,15.163 -11.195,29.202 -22.527,19.553 -3.984,-3.393 -4.514,-11.023 -0.922,-13.288 1.307,-0.825 3.298,1.725 2.681,3.432 -1.939,5.363 7.008,7.426 9.66,2.228 4.922,-9.65 -9.855,-16.863 -17.262,-8.426 -8.349,9.508 -3.55,23.167 9.81,27.925 28.746,10.238 48.599,-34.388 25.463,-57.234 -22.72,-22.436 -58.267,-22.516 -80.463,-0.183 -11.414,11.485 -20.125,27.441 -23.267,42.619 -0.227,1.1 -0.57,2.72 -0.76,3.6 -3.902,18.01 0.409,43.215 10.16,59.4 0.862,1.43 1.922,3.23 2.356,4 0.434,0.77 1.104,1.76 1.49,2.2 0.386,0.44 1.298,1.7 2.028,2.8 8.173,12.316 40.814,37.557 49.496,38.276 l 1.497,0.124 0.203,37.6 0.203,37.6 0.097,-36.5 c 0.053,-20.075 0.17,-36.5 0.259,-36.5 0.128,0 17.03,17.01 19.938,20.065 0.65,0.682 0.707,2.603 0.797,26.835 0.095,25.618 0.101,25.406 0.3,-11.5 l 0.203,-37.6 2.4,-0.318 c 18.371,-2.431 34.937,-7.731 47.2,-15.099 1.1,-0.66 2.27,-1.319 2.6,-1.464 11.86,-5.185 38.534,-31.859 43.719,-43.719 0.145,-0.33 0.804,-1.5 1.464,-2.6 6.518,-10.847 12.079,-27.115 14.358,-42 4.085,-26.677 -1.36,-56.958 -14.205,-79 -0.577,-0.99 -1.404,-2.43 -1.838,-3.2 -5.877,-10.424 -17.544,-23.974 -27.898,-32.399 -1.21,-0.984 -2.29,-1.891 -2.4,-2.014 -0.11,-0.123 -1.73,-1.313 -3.6,-2.643 -2.952,-2.101 -5.708,-3.889 -11.6,-7.525 -0.77,-0.475 -3.74,-1.993 -6.6,-3.373 -5.077,-2.451 -6.258,-2.991 -8.1,-3.7 -0.495,-0.19 -1.305,-0.526 -1.8,-0.746 -5.508,-2.445 -19.57,-5.979 -28.9,-7.262 -3.846,-0.529 -25.757,-0.749 -29.2,-0.294" style="fill:#eb5586;fill-rule:evenodd;stroke:none" />
						<path id="path1" d="m 171,109.815 c -6.266,0.621 -6.73,0.701 -14,2.407 -2.824,0.663 -10.349,3.036 -12.2,3.847 -0.55,0.241 -1.36,0.57 -1.8,0.732 -27.488,10.097 -54.571,40.759 -66.245,74.999 -2.947,8.642 0.731,37.841 6.462,51.3 0.354,0.833 0.566,1.354 1.542,3.8 6.925,17.348 21.751,37.74 35.041,48.193 0.88,0.692 2.59,2.05 3.8,3.016 5.256,4.201 16.809,11.403 22.4,13.965 11.39,5.22 21.343,8.412 32.187,10.324 7.505,1.323 7.874,1.158 2.995,-1.337 -14.833,-7.585 -36.321,-25.334 -43.175,-35.661 -0.73,-1.1 -1.642,-2.36 -2.028,-2.8 -0.386,-0.44 -1.056,-1.43 -1.49,-2.2 -0.434,-0.77 -1.494,-2.57 -2.356,-4 -9.751,-16.185 -14.062,-41.39 -10.16,-59.4 0.19,-0.88 0.533,-2.5 0.76,-3.6 4.676,-22.591 20.357,-44.508 38.283,-53.508 35.407,-17.777 81.279,8.026 75.217,42.308 -4.09,23.13 -24.491,34.396 -41.431,22.879 -8.492,-5.774 -10.175,-17.332 -3.612,-24.806 7.407,-8.437 22.184,-1.224 17.262,8.426 -2.652,5.198 -11.599,3.135 -9.66,-2.228 0.617,-1.707 -1.374,-4.257 -2.681,-3.432 -3.592,2.265 -3.062,9.895 0.922,13.288 11.332,9.649 27.505,-4.39 22.527,-19.553 -2.09,-6.366 -8.417,-12.349 -15.16,-14.337 -0.99,-0.292 -2.322,-0.689 -2.96,-0.884 -6.808,-2.074 -16.731,0.816 -24.196,7.047 -3.746,3.127 -8.625,11.33 -10.111,17 -5.288,20.185 5.873,39.463 28.267,48.825 23.686,9.903 52.878,-1.559 67.43,-26.476 2.266,-3.88 3.628,-6.648 5.585,-11.349 5.086,-12.222 6.06,-30.085 2.394,-43.91 -0.876,-3.3 -1.829,-6.371 -2.388,-7.69 -0.187,-0.44 -0.647,-1.52 -1.023,-2.4 C 252.658,128.109 211.854,105.766 171,109.815 M 189.595,362.1 c -0.003,19.855 -0.114,36.505 -0.247,37 l -0.241,0.9 h 10.746 10.747 l -0.111,-26.611 c -0.102,-24.544 -0.165,-26.667 -0.8,-27.335 C 206.833,343.051 189.89,326 189.762,326 c -0.089,0 -0.164,16.245 -0.167,36.1" style="fill:#fbd8b1;fill-rule:evenodd;stroke:none" />
						<path id="path2" d="m 178.7,0.273 c -2.145,0.086 -3.9,0.329 -3.9,0.541 0,0.213 -1.159,0.386 -2.576,0.386 -1.417,0 -2.688,0.18 -2.824,0.4 -0.136,0.22 -1.317,0.4 -2.624,0.4 -1.317,0 -2.376,0.178 -2.376,0.4 0,0.22 -0.889,0.4 -1.976,0.4 -1.087,0 -2.088,0.18 -2.224,0.4 -0.136,0.22 -0.946,0.4 -1.8,0.4 -0.854,0 -1.664,0.18 -1.8,0.4 -0.136,0.22 -0.946,0.4 -1.8,0.4 -0.854,0 -1.664,0.18 -1.8,0.4 -0.136,0.22 -0.856,0.4 -1.6,0.4 -0.744,0 -1.464,0.18 -1.6,0.4 -0.136,0.22 -0.867,0.4 -1.624,0.4 -0.757,0 -1.376,0.18 -1.376,0.4 0,0.22 -0.529,0.4 -1.176,0.4 -0.647,0 -1.288,0.18 -1.424,0.4 -0.136,0.22 -0.766,0.4 -1.4,0.4 -0.634,0 -1.264,0.18 -1.4,0.4 -0.136,0.22 -0.777,0.4 -1.424,0.4 -0.647,0 -1.176,0.142 -1.176,0.315 0,0.173 -0.337,0.34 -0.75,0.371 -0.888,0.067 -6.747,1.982 -7.745,2.531 -0.382,0.211 -1.057,0.383 -1.5,0.383 -0.443,0 -0.805,0.18 -0.805,0.4 0,0.22 -0.343,0.4 -0.762,0.4 -0.419,0 -1.544,0.386 -2.5,0.857 -0.956,0.471 -2.098,0.985 -2.538,1.143 -0.44,0.158 -1.582,0.672 -2.538,1.143 -0.956,0.471 -1.991,0.857 -2.3,0.857 -0.309,0 -0.562,0.18 -0.562,0.4 0,0.22 -0.349,0.4 -0.776,0.4 -0.427,0 -0.888,0.18 -1.024,0.4 -0.136,0.22 -0.582,0.4 -0.99,0.4 -0.409,0 -0.803,0.135 -0.877,0.3 -0.192,0.432 -3.505,2.1 -4.171,2.1 -0.309,0 -0.562,0.18 -0.562,0.4 0,0.22 -0.36,0.4 -0.8,0.4 -0.44,0 -0.8,0.145 -0.8,0.321 0,0.177 -0.897,0.762 -1.994,1.3 -1.096,0.539 -1.996,1.114 -2,1.279 -0.003,0.165 -0.366,0.3 -0.806,0.3 -0.44,0 -0.8,0.18 -0.8,0.4 0,0.22 -0.315,0.413 -0.7,0.428 -0.385,0.016 -1.78,0.739 -3.1,1.607 -1.32,0.868 -2.715,1.686 -3.1,1.818 -0.385,0.132 -0.7,0.377 -0.7,0.545 0,0.168 -0.54,0.529 -1.2,0.802 -0.66,0.273 -1.2,0.655 -1.2,0.849 0,0.193 -0.236,0.351 -0.525,0.351 -0.288,0 -0.911,0.36 -1.383,0.8 -0.472,0.44 -1.096,0.8 -1.387,0.8 -0.291,0 -0.788,0.36 -1.105,0.8 -0.317,0.44 -0.762,0.8 -0.988,0.801 -0.227,0 -1.042,0.54 -1.812,1.199 -0.77,0.659 -1.559,1.199 -1.753,1.199 -0.194,0.001 -0.644,0.316 -1,0.701 -0.822,0.888 -3.921,3.3 -4.242,3.3 -0.133,0 -0.658,0.405 -1.168,0.9 -0.51,0.495 -1.35,1.17 -1.867,1.5 -0.517,0.33 -1.532,1.188 -2.255,1.907 -0.723,0.719 -1.315,1.187 -1.315,1.039 0,-0.148 -0.315,0.075 -0.7,0.494 -0.385,0.42 -1.512,1.414 -2.505,2.21 -0.992,0.796 -3.332,3 -5.2,4.897 -4.131,4.197 -3.651,3.717 -7.848,7.848 -1.897,1.868 -4.101,4.208 -4.897,5.2 -0.796,0.993 -1.79,2.12 -2.21,2.505 -0.419,0.385 -0.62,0.7 -0.447,0.7 0.173,0 -0.294,0.537 -1.039,1.194 -0.745,0.656 -1.213,1.196 -1.04,1.2 0.292,0.006 -0.02,0.392 -2.414,2.992 -0.495,0.538 -0.9,1.086 -0.9,1.219 0,0.321 -2.412,3.42 -3.3,4.242 -0.385,0.356 -0.7,0.806 -0.701,1 0,0.194 -0.54,0.983 -1.199,1.753 -0.659,0.77 -1.199,1.585 -1.199,1.812 C 34.8,86.038 34.44,86.483 34,86.8 c -0.44,0.317 -0.8,0.814 -0.8,1.105 0,0.291 -0.36,0.915 -0.8,1.387 -0.44,0.472 -0.8,1.095 -0.8,1.383 0,0.289 -0.158,0.525 -0.351,0.525 -0.194,0 -0.576,0.54 -0.849,1.2 -0.273,0.66 -0.634,1.2 -0.802,1.2 -0.168,0 -0.413,0.315 -0.545,0.7 -0.132,0.385 -0.95,1.78 -1.818,3.1 -0.868,1.32 -1.591,2.715 -1.607,3.1 -0.015,0.385 -0.208,0.7 -0.428,0.7 -0.22,0 -0.4,0.36 -0.4,0.8 0,0.44 -0.135,0.803 -0.3,0.806 -0.165,0.004 -0.74,0.904 -1.279,2 -0.538,1.097 -1.123,1.994 -1.3,1.994 -0.176,0 -0.321,0.36 -0.321,0.8 0,0.44 -0.18,0.8 -0.4,0.8 -0.22,0 -0.4,0.253 -0.4,0.562 0,0.666 -1.668,3.979 -2.1,4.171 -0.165,0.074 -0.3,0.468 -0.3,0.877 0,0.408 -0.18,0.854 -0.4,0.99 -0.22,0.136 -0.4,0.597 -0.4,1.024 0,0.427 -0.18,0.776 -0.4,0.776 -0.22,0 -0.4,0.253 -0.4,0.562 0,0.309 -0.386,1.344 -0.857,2.3 -0.471,0.956 -0.985,2.098 -1.143,2.538 -0.158,0.44 -0.672,1.582 -1.143,2.538 -0.471,0.956 -0.857,2.081 -0.857,2.5 0,0.419 -0.18,0.762 -0.4,0.762 -0.22,0 -0.4,0.362 -0.4,0.805 0,0.443 -0.172,1.118 -0.383,1.5 -0.549,0.998 -2.464,6.857 -2.531,7.745 -0.031,0.413 -0.198,0.75 -0.371,0.75 -0.173,0 -0.315,0.529 -0.315,1.176 0,0.647 -0.18,1.288 -0.4,1.424 -0.22,0.136 -0.4,0.766 -0.4,1.4 0,0.634 -0.18,1.264 -0.4,1.4 -0.22,0.136 -0.4,0.777 -0.4,1.424 0,0.647 -0.18,1.176 -0.4,1.176 -0.22,0 -0.4,0.619 -0.4,1.376 0,0.757 -0.18,1.488 -0.4,1.624 -0.22,0.136 -0.4,0.856 -0.4,1.6 0,0.744 -0.18,1.464 -0.4,1.6 -0.22,0.136 -0.4,0.946 -0.4,1.8 0,0.854 -0.18,1.664 -0.4,1.8 -0.22,0.136 -0.4,0.946 -0.4,1.8 0,0.854 -0.18,1.664 -0.4,1.8 -0.22,0.136 -0.4,1.137 -0.4,2.224 0,1.087 -0.18,1.976 -0.4,1.976 -0.222,0 -0.4,1.059 -0.4,2.376 0,1.307 -0.18,2.488 -0.4,2.624 -0.22,0.136 -0.4,1.392 -0.4,2.79 0,1.679 -0.17,2.6 -0.5,2.71 -0.732,0.244 -0.732,49.956 0,50.2 0.33,0.11 0.5,1.031 0.5,2.71 0,1.398 0.18,2.654 0.4,2.79 0.22,0.136 0.4,1.317 0.4,2.624 0,1.317 0.178,2.376 0.4,2.376 0.22,0 0.4,0.799 0.4,1.776 0,0.977 0.18,1.888 0.4,2.024 0.22,0.136 0.4,1.036 0.4,2 0,0.964 0.18,1.864 0.4,2 0.22,0.136 0.4,0.946 0.4,1.8 0,0.854 0.18,1.664 0.4,1.8 0.22,0.136 0.4,0.856 0.4,1.6 0,0.744 0.18,1.464 0.4,1.6 0.22,0.136 0.4,0.867 0.4,1.624 0,0.757 0.18,1.376 0.4,1.376 0.22,0 0.4,0.529 0.4,1.176 0,0.647 0.18,1.288 0.4,1.424 0.22,0.136 0.4,0.676 0.4,1.2 0,0.524 0.18,1.064 0.4,1.2 0.22,0.136 0.4,0.706 0.4,1.267 0,1.032 2.482,8.947 3.207,10.228 0.216,0.382 0.393,1.057 0.393,1.5 0,0.443 0.18,0.805 0.4,0.805 0.22,0 0.4,0.272 0.4,0.604 0,0.333 0.378,1.458 0.84,2.5 0.462,1.043 0.976,2.256 1.143,2.696 0.167,0.44 0.689,1.582 1.16,2.538 0.471,0.956 0.857,1.991 0.857,2.3 0,0.309 0.18,0.562 0.4,0.562 0.22,0 0.4,0.36 0.4,0.8 0,0.44 0.18,0.8 0.4,0.8 0.22,0 0.4,0.435 0.4,0.967 0,0.531 0.137,1.026 0.305,1.1 0.168,0.073 1.273,2.068 2.457,4.433 1.183,2.365 2.306,4.3 2.495,4.3 0.188,0 0.343,0.36 0.343,0.8 0,0.44 0.18,0.8 0.4,0.8 0.22,0 0.4,0.36 0.4,0.8 0,0.44 0.18,0.8 0.4,0.8 0.22,0 0.4,0.283 0.4,0.63 0,0.346 0.81,1.882 1.8,3.412 0.99,1.531 1.8,2.957 1.8,3.17 0,0.214 0.18,0.388 0.4,0.388 0.22,0 0.4,0.236 0.4,0.525 0,0.288 0.315,0.873 0.7,1.3 0.385,0.426 0.955,1.27 1.268,1.875 0.312,0.605 0.717,1.1 0.9,1.1 0.182,0 0.332,0.272 0.332,0.604 0,0.332 0.54,1.168 1.2,1.859 0.66,0.691 1.2,1.416 1.2,1.613 0,0.197 0.36,0.744 0.8,1.216 0.44,0.472 0.8,1.095 0.8,1.383 0,0.289 0.155,0.525 0.345,0.525 0.19,0 1.307,1.305 2.483,2.9 1.175,1.595 2.487,3.215 2.916,3.6 0.428,0.385 0.616,0.703 0.417,0.706 -0.198,0.003 -0.176,0.138 0.049,0.3 0.226,0.162 1.007,1.06 1.735,1.995 0.729,0.936 1.894,2.297 2.59,3.023 0.696,0.727 1.715,1.926 2.265,2.665 0.55,0.738 2.503,2.798 4.34,4.577 4.061,3.932 3.562,3.433 7.494,7.494 1.779,1.837 3.839,3.79 4.577,4.34 0.739,0.55 1.938,1.569 2.665,2.265 0.726,0.696 2.087,1.864 3.023,2.594 0.935,0.731 1.92,1.512 2.187,1.735 0.952,0.794 1.549,1.251 4.414,3.37 1.595,1.18 2.9,2.301 2.9,2.491 0,0.19 0.236,0.345 0.525,0.345 0.288,0 0.911,0.36 1.383,0.8 0.472,0.44 1.019,0.8 1.216,0.8 0.197,0 0.922,0.54 1.613,1.2 0.691,0.66 1.445,1.2 1.676,1.2 0.231,0 0.807,0.36 1.279,0.8 0.472,0.44 1.095,0.8 1.383,0.8 0.289,0 0.525,0.18 0.525,0.4 0,0.22 0.27,0.4 0.6,0.4 0.33,0 0.6,0.18 0.6,0.4 0,0.22 0.27,0.4 0.6,0.4 0.33,0 0.6,0.18 0.6,0.4 0,0.22 0.174,0.4 0.388,0.4 0.213,0 1.639,0.81 3.17,1.8 1.53,0.99 3.066,1.8 3.412,1.8 0.347,0 0.63,0.18 0.63,0.4 0,0.22 0.36,0.4 0.8,0.4 0.44,0 0.8,0.18 0.8,0.4 0,0.22 0.36,0.4 0.8,0.4 0.44,0 0.8,0.152 0.8,0.337 0,0.186 0.855,0.771 1.9,1.3 1.045,0.53 1.96,1.098 2.033,1.263 0.074,0.165 0.353,0.3 0.621,0.3 0.709,0 2.639,0.949 2.643,1.3 0.002,0.165 0.363,0.3 0.803,0.3 0.44,0 0.8,0.18 0.8,0.4 0,0.22 0.349,0.4 0.776,0.4 0.427,0 0.888,0.18 1.024,0.4 0.136,0.22 0.597,0.4 1.024,0.4 0.427,0 0.776,0.18 0.776,0.4 0,0.22 0.253,0.4 0.562,0.4 0.485,0 1.758,0.552 4.733,2.05 0.382,0.193 0.967,0.35 1.3,0.35 0.333,0 0.605,0.18 0.605,0.4 0,0.22 0.439,0.4 0.976,0.4 0.537,0 1.088,0.18 1.224,0.4 0.136,0.22 0.597,0.4 1.024,0.4 0.427,0 0.776,0.191 0.776,0.424 0,0.233 0.148,0.332 0.329,0.22 0.18,-0.112 0.765,0.018 1.3,0.288 0.534,0.271 2.051,0.831 3.371,1.246 1.32,0.415 3.39,1.067 4.6,1.448 1.21,0.381 3.01,0.909 4,1.172 0.99,0.264 2.113,0.642 2.495,0.841 0.382,0.199 1.136,0.361 1.676,0.361 0.54,0 1.093,0.18 1.229,0.4 0.136,0.22 0.867,0.4 1.624,0.4 0.757,0 1.376,0.18 1.376,0.4 0,0.22 0.709,0.4 1.576,0.4 0.867,0 1.688,0.18 1.824,0.4 0.136,0.22 0.957,0.4 1.824,0.4 0.867,0 1.576,0.18 1.576,0.4 0,0.22 0.799,0.4 1.776,0.4 0.977,0 1.888,0.18 2.024,0.4 0.136,0.22 1.047,0.4 2.024,0.4 0.977,0 1.776,0.18 1.776,0.4 0,0.222 1.067,0.4 2.4,0.4 1.333,0 2.4,0.178 2.4,0.4 0,0.231 1.256,0.4 2.967,0.4 1.631,0 3.026,0.158 3.1,0.352 0.073,0.193 3.148,0.483 6.833,0.642 l 6.7,0.291 -0.002,-17.542 L 188.796,365 155.821,332.01 c -18.136,-18.144 -32.892,-33.072 -32.791,-33.173 0.101,-0.101 0.396,0.029 0.657,0.29 0.26,0.26 0.662,0.472 0.893,0.47 0.231,-10e-4 -0.109,-0.351 -0.755,-0.777 -0.646,-0.426 -1.326,-0.681 -1.51,-0.567 -0.184,0.113 -0.285,0.058 -0.225,-0.123 0.061,-0.182 -0.005,-0.397 -0.145,-0.479 -6.214,-3.631 -25.467,-25.943 -29.553,-34.251 -0.325,-0.66 -0.681,-1.29 -0.791,-1.4 -0.408,-0.406 -1.648,-2.705 -3.56,-6.6 -2.996,-6.101 -3.809,-8.024 -5.408,-12.8 -0.811,-2.42 -1.645,-4.713 -1.854,-5.095 -0.208,-0.382 -0.379,-1.136 -0.379,-1.676 0,-0.54 -0.18,-1.093 -0.4,-1.229 -0.22,-0.136 -0.4,-0.766 -0.4,-1.4 0,-0.634 -0.161,-1.252 -0.358,-1.374 -0.197,-0.121 -0.467,-0.942 -0.6,-1.823 -0.133,-0.882 -0.351,-2.324 -0.484,-3.206 -0.133,-0.881 -0.403,-1.702 -0.6,-1.823 -0.197,-0.122 -0.358,-1.075 -0.358,-2.118 0,-1.043 -0.165,-2.067 -0.368,-2.276 -0.202,-0.209 -0.465,-1.55 -0.585,-2.98 -0.119,-1.43 -0.432,-5.12 -0.695,-8.2 -0.959,-11.257 -0.073,-24.224 2.427,-35.5 0.231,-1.045 0.587,-2.665 0.791,-3.6 0.203,-0.935 0.563,-2.375 0.8,-3.2 0.236,-0.825 0.595,-2.085 0.797,-2.8 10.948,-38.8 44.841,-72.724 83.833,-83.911 3.481,-0.998 4.548,-1.281 6.1,-1.619 0.935,-0.204 2.555,-0.56 3.6,-0.791 9.648,-2.139 22.053,-3.032 33.2,-2.39 8.461,0.487 12.98,1.055 19,2.39 1.045,0.231 2.665,0.587 3.6,0.791 0.935,0.203 2.33,0.553 3.1,0.777 0.77,0.224 2.03,0.577 2.8,0.783 5.763,1.544 23.588,9.049 24.8,10.441 0.11,0.127 0.74,0.496 1.4,0.82 0.66,0.324 2.497,1.449 4.082,2.499 1.585,1.051 3.07,1.91 3.3,1.91 0.23,0 0.418,0.141 0.418,0.314 0,0.172 0.53,0.626 1.177,1.009 6.218,3.673 17.779,14.159 24.603,22.315 1.731,2.069 3.384,3.853 3.674,3.964 0.687,0.263 99.746,99.252 99.746,99.676 0,0.177 0.153,0.322 0.339,0.322 0.853,0 1.005,-48.019 0.154,-48.302 -0.332,-0.111 -0.493,-1.137 -0.493,-3.131 0,-1.711 -0.169,-2.967 -0.4,-2.967 -0.222,0 -0.4,-1.067 -0.4,-2.4 0,-1.333 -0.178,-2.4 -0.4,-2.4 -0.22,0 -0.4,-0.889 -0.4,-1.976 0,-1.087 -0.18,-2.088 -0.4,-2.224 -0.22,-0.136 -0.4,-0.957 -0.4,-1.824 0,-0.867 -0.18,-1.576 -0.4,-1.576 -0.22,0 -0.4,-0.709 -0.4,-1.576 0,-0.867 -0.18,-1.688 -0.4,-1.824 -0.22,-0.136 -0.4,-0.957 -0.4,-1.824 0,-0.867 -0.18,-1.576 -0.4,-1.576 -0.22,0 -0.4,-0.619 -0.4,-1.376 0,-0.757 -0.18,-1.488 -0.4,-1.624 -0.22,-0.136 -0.4,-0.766 -0.4,-1.4 0,-0.634 -0.18,-1.264 -0.4,-1.4 -0.22,-0.136 -0.4,-0.689 -0.4,-1.229 0,-0.54 -0.156,-1.294 -0.346,-1.676 -0.19,-0.382 -0.751,-2.045 -1.246,-3.695 -1.399,-4.659 -2.158,-6.915 -2.684,-7.971 -0.266,-0.535 -0.392,-1.12 -0.28,-1.3 0.112,-0.181 0.013,-0.329 -0.22,-0.329 -0.233,0 -0.424,-0.349 -0.424,-0.776 0,-0.427 -0.18,-0.888 -0.4,-1.024 -0.22,-0.136 -0.4,-0.687 -0.4,-1.224 0,-0.537 -0.18,-0.976 -0.4,-0.976 -0.22,0 -0.4,-0.272 -0.4,-0.605 0,-0.333 -0.157,-0.918 -0.35,-1.3 -1.498,-2.975 -2.05,-4.248 -2.05,-4.733 0,-0.309 -0.18,-0.562 -0.4,-0.562 -0.22,0 -0.4,-0.349 -0.4,-0.776 0,-0.427 -0.18,-0.888 -0.4,-1.024 -0.22,-0.136 -0.4,-0.597 -0.4,-1.024 0,-0.427 -0.18,-0.776 -0.4,-0.776 -0.22,0 -0.4,-0.36 -0.4,-0.8 0,-0.44 -0.18,-0.8 -0.4,-0.8 -0.22,0 -0.4,-0.36 -0.4,-0.8 0,-0.44 -0.18,-0.8 -0.4,-0.8 -0.22,0 -0.4,-0.345 -0.4,-0.767 0,-0.421 -0.135,-0.826 -0.3,-0.9 -0.165,-0.073 -0.733,-0.988 -1.263,-2.033 -0.529,-1.045 -1.114,-1.9 -1.3,-1.9 -0.185,0 -0.337,-0.36 -0.337,-0.8 0,-0.44 -0.18,-0.8 -0.4,-0.8 -0.22,0 -0.4,-0.36 -0.4,-0.8 0,-0.44 -0.18,-0.8 -0.4,-0.8 -0.22,0 -0.4,-0.338 -0.4,-0.751 0,-0.413 -0.27,-0.975 -0.6,-1.249 -0.33,-0.274 -0.6,-0.668 -0.6,-0.877 0,-0.208 -0.54,-1.164 -1.2,-2.123 -0.66,-0.959 -1.2,-1.937 -1.2,-2.172 0,-0.235 -0.18,-0.428 -0.4,-0.428 -0.22,0 -0.4,-0.27 -0.4,-0.6 0,-0.33 -0.18,-0.6 -0.4,-0.6 -0.22,0 -0.4,-0.27 -0.4,-0.6 0,-0.33 -0.18,-0.6 -0.4,-0.6 -0.22,0 -0.4,-0.236 -0.4,-0.525 0,-0.288 -0.36,-0.911 -0.8,-1.383 -0.44,-0.472 -0.8,-1.048 -0.8,-1.279 0,-0.231 -0.54,-0.985 -1.2,-1.676 -0.66,-0.691 -1.2,-1.416 -1.2,-1.613 0,-0.197 -0.36,-0.744 -0.8,-1.216 -0.44,-0.472 -0.8,-1.095 -0.8,-1.383 0,-0.289 -0.159,-0.525 -0.354,-0.525 -0.195,0 -1.14,-1.078 -2.1,-2.396 -0.96,-1.318 -1.881,-2.398 -2.046,-2.4 -0.165,-0.002 -0.3,-0.197 -0.3,-0.433 0,-0.235 -0.225,-0.67 -0.5,-0.965 -0.275,-0.295 -0.95,-1.135 -1.5,-1.867 -0.837,-1.112 -2.195,-2.698 -4.6,-5.368 -0.22,-0.244 -0.85,-1.042 -1.4,-1.773 -0.55,-0.731 -2.503,-2.785 -4.34,-4.564 -4.061,-3.932 -3.562,-3.433 -7.494,-7.494 -1.779,-1.837 -3.839,-3.79 -4.577,-4.34 -0.739,-0.55 -1.938,-1.569 -2.665,-2.265 -0.726,-0.696 -2.087,-1.861 -3.023,-2.59 -0.935,-0.728 -1.833,-1.509 -1.995,-1.735 -0.162,-0.225 -0.297,-0.247 -0.3,-0.049 -0.003,0.199 -0.321,0.011 -0.706,-0.417 -0.385,-0.429 -2.005,-1.741 -3.6,-2.916 -1.595,-1.176 -2.9,-2.293 -2.9,-2.483 0,-0.19 -0.236,-0.345 -0.525,-0.345 -0.288,0 -0.911,-0.36 -1.383,-0.8 -0.472,-0.44 -1.019,-0.8 -1.216,-0.8 -0.197,0 -0.922,-0.54 -1.613,-1.2 -0.691,-0.66 -1.527,-1.2 -1.859,-1.2 -0.332,0 -0.604,-0.15 -0.604,-0.332 0,-0.183 -0.495,-0.588 -1.1,-0.9 -0.605,-0.313 -1.449,-0.883 -1.875,-1.268 -0.427,-0.385 -1.012,-0.7 -1.3,-0.7 -0.289,0 -0.525,-0.18 -0.525,-0.4 0,-0.22 -0.174,-0.4 -0.388,-0.4 -0.213,0 -1.639,-0.81 -3.17,-1.8 -1.53,-0.99 -2.94,-1.8 -3.132,-1.8 -0.604,0 -2.504,-0.985 -2.507,-1.3 -0.002,-0.165 -0.363,-0.3 -0.803,-0.3 -0.44,0 -0.8,-0.155 -0.8,-0.343 0,-0.189 -1.935,-1.312 -4.3,-2.495 -2.365,-1.184 -4.36,-2.289 -4.433,-2.457 -0.074,-0.168 -0.569,-0.305 -1.1,-0.305 -0.532,0 -0.967,-0.18 -0.967,-0.4 0,-0.22 -0.36,-0.4 -0.8,-0.4 -0.44,0 -0.8,-0.18 -0.8,-0.4 0,-0.22 -0.253,-0.4 -0.562,-0.4 -0.309,0 -1.344,-0.386 -2.3,-0.857 -0.956,-0.471 -2.098,-0.993 -2.538,-1.16 -0.44,-0.167 -1.653,-0.681 -2.696,-1.143 -1.042,-0.462 -2.167,-0.84 -2.5,-0.84 -0.332,0 -0.604,-0.18 -0.604,-0.4 0,-0.22 -0.362,-0.4 -0.805,-0.4 -0.443,0 -1.118,-0.177 -1.5,-0.393 C 268.414,10.882 260.499,8.4 259.467,8.4 258.906,8.4 258.336,8.22 258.2,8 258.064,7.78 257.524,7.6 257,7.6 c -0.524,0 -1.064,-0.18 -1.2,-0.4 -0.136,-0.22 -0.777,-0.4 -1.424,-0.4 -0.647,0 -1.176,-0.18 -1.176,-0.4 0,-0.22 -0.619,-0.4 -1.376,-0.4 -0.757,0 -1.488,-0.18 -1.624,-0.4 -0.136,-0.22 -0.856,-0.4 -1.6,-0.4 -0.744,0 -1.464,-0.18 -1.6,-0.4 -0.136,-0.22 -0.946,-0.4 -1.8,-0.4 -0.854,0 -1.664,-0.18 -1.8,-0.4 -0.136,-0.22 -1.036,-0.4 -2,-0.4 -0.964,0 -1.864,-0.18 -2,-0.4 C 239.264,2.98 238.353,2.8 237.376,2.8 236.399,2.8 235.6,2.62 235.6,2.4 235.6,2.178 234.541,2 233.224,2 231.917,2 230.736,1.82 230.6,1.6 230.464,1.38 229.208,1.2 227.81,1.2 226.189,1.2 225.209,1.026 225.107,0.72 224.948,0.244 188.291,-0.109 178.7,0.273 M 324.509,196.8 c 0,0.99 0.078,1.395 0.173,0.9 0.096,-0.495 0.096,-1.305 0,-1.8 -0.095,-0.495 -0.173,-0.09 -0.173,0.9 m 0,6.4 c 0,0.99 0.078,1.395 0.173,0.9 0.096,-0.495 0.096,-1.305 0,-1.8 -0.095,-0.495 -0.173,-0.09 -0.173,0.9 m -197.28,98.596 c 1.414,0.987 2.727,1.797 2.918,1.8 0.19,0.002 -0.837,-0.806 -2.283,-1.796 -1.446,-0.99 -2.759,-1.8 -2.917,-1.8 -0.159,0 0.868,0.808 2.282,1.796 m 36.371,17.959 c 0,0.085 0.53,0.232 1.179,0.327 0.648,0.095 1.088,0.026 0.976,-0.154 -0.198,-0.321 -2.155,-0.478 -2.155,-0.173 m 21.004,4.251 c 0.134,0.217 0.803,0.394 1.486,0.394 1.511,0 1.359,-0.2 -0.41,-0.537 -0.825,-0.157 -1.228,-0.103 -1.076,0.143 m 26.596,69.968 v 6.142 l 5.5,-0.283 c 3.025,-0.155 5.591,-0.406 5.703,-0.558 0.112,-0.151 -2.363,-2.788 -5.5,-5.86 l -5.703,-5.584 v 6.143 m 34.615,1.202 c -0.128,0.206 0.132,0.348 0.576,0.315 0.445,-0.034 0.809,-0.203 0.809,-0.376 0,-0.442 -1.104,-0.394 -1.385,0.061" style="fill:#63539c;fill-rule:evenodd;stroke:none" />
						<path id="path3" d="m 299.207,124.124 c 1.266,1.395 8.052,11.784 9.194,14.076 0.329,0.66 0.706,1.29 0.838,1.4 1.418,1.182 8.758,18.599 10.409,24.7 0.194,0.715 0.546,1.975 0.782,2.8 0.237,0.825 0.597,2.265 0.8,3.2 0.204,0.935 0.56,2.555 0.791,3.6 1.328,5.989 1.899,10.511 2.401,19 0.653,11.032 -0.248,23.49 -2.401,33.2 -0.231,1.045 -0.587,2.665 -0.791,3.6 -0.203,0.935 -0.563,2.375 -0.8,3.2 -0.236,0.825 -0.588,2.085 -0.781,2.8 -1.625,6.015 -9.007,23.53 -10.41,24.7 -0.132,0.11 -0.509,0.74 -0.838,1.4 -4.511,9.054 -17.169,24.456 -26.827,32.643 -6.51,5.517 -15.333,11.745 -19.774,13.958 -0.66,0.329 -1.29,0.706 -1.4,0.838 -0.302,0.363 -10.689,5.381 -13.2,6.378 -2.995,1.188 -9.885,3.597 -11.6,4.054 -0.77,0.206 -2.03,0.558 -2.8,0.782 -0.77,0.224 -2.165,0.574 -3.1,0.777 -0.935,0.204 -2.555,0.56 -3.6,0.791 -2.754,0.611 -5.93,1.166 -8.9,1.557 -1.43,0.188 -3.365,0.474 -4.3,0.635 l -1.7,0.292 v 31.666 31.665 l 5.732,5.683 c 3.153,3.126 5.643,5.773 5.534,5.882 -0.11,0.11 0.356,0.199 1.034,0.199 0.678,0 1.324,-0.225 1.435,-0.5 0.149,-0.369 0.21,-0.356 0.233,0.049 0.024,0.411 0.166,0.438 0.564,0.107 0.293,-0.243 1.598,-0.478 2.9,-0.523 1.302,-0.044 2.572,-0.232 2.822,-0.417 0.249,-0.185 1.112,-0.362 1.916,-0.392 0.805,-0.03 1.557,-0.205 1.67,-0.389 0.335,-0.542 1.034,-0.383 0.725,0.165 -0.226,0.4 -0.175,0.4 0.256,0 0.297,-0.275 0.923,-0.5 1.392,-0.5 0.47,0 0.99,-0.135 1.156,-0.3 0.304,-0.301 0.507,-0.331 2.955,-0.441 0.768,-0.034 1.22,-0.227 1.076,-0.459 -0.136,-0.22 0.018,-0.4 0.343,-0.4 0.325,0 0.681,0.225 0.792,0.5 0.161,0.4 0.208,0.4 0.233,0 0.018,-0.275 0.356,-0.5 0.752,-0.5 0.396,0 0.891,-0.166 1.1,-0.368 0.209,-0.203 1.19,-0.414 2.18,-0.471 0.99,-0.056 1.989,-0.242 2.219,-0.413 0.231,-0.172 1.086,-0.357 1.9,-0.412 0.815,-0.055 1.481,-0.243 1.481,-0.418 0,-0.175 0.345,-0.318 0.767,-0.318 0.421,0 0.858,-0.225 0.969,-0.5 0.153,-0.376 0.308,-0.352 0.627,0.1 0.288,0.407 0.427,0.439 0.431,0.1 0.003,-0.275 0.445,-0.5 0.982,-0.5 0.537,0 1.076,-0.16 1.197,-0.356 0.189,-0.306 1.701,-0.667 3.81,-0.91 0.32,-0.037 1.027,-0.298 1.571,-0.58 0.544,-0.282 1.164,-0.404 1.379,-0.272 0.217,0.134 0.263,0.036 0.105,-0.22 -0.252,-0.409 1.108,-0.705 2.292,-0.499 0.181,0.031 0.215,-0.128 0.076,-0.353 -0.144,-0.234 0.144,-0.415 0.67,-0.423 0.508,-0.007 1.256,-0.264 1.663,-0.572 0.406,-0.308 0.982,-0.467 1.279,-0.353 0.297,0.114 0.937,-0.162 1.422,-0.613 0.485,-0.452 1.019,-0.736 1.188,-0.631 0.169,0.104 0.572,-0.075 0.896,-0.399 0.323,-0.323 1.226,-0.631 2.006,-0.684 0.78,-0.052 1.353,-0.201 1.273,-0.33 -0.08,-0.129 0.427,-0.465 1.126,-0.746 0.699,-0.281 1.584,-0.68 1.966,-0.885 0.382,-0.206 1.035,-0.374 1.451,-0.374 0.416,0 0.987,-0.278 1.269,-0.618 0.282,-0.34 0.71,-0.543 0.951,-0.45 0.516,0.198 1.497,-0.736 1.143,-1.089 -0.133,-0.134 -0.047,-0.243 0.191,-0.243 0.238,0 0.524,0.225 0.635,0.5 0.161,0.4 0.208,0.4 0.233,0 0.018,-0.275 0.437,-0.503 0.932,-0.506 0.728,-0.005 0.785,-0.08 0.3,-0.394 -0.495,-0.32 -0.456,-0.389 0.22,-0.394 0.979,-0.007 2.972,-0.882 2.977,-1.306 0.002,-0.165 0.408,-0.314 0.903,-0.332 0.495,-0.017 0.662,-0.126 0.372,-0.242 -0.583,-0.233 1.208,-1.326 2.174,-1.326 0.305,0 0.554,-0.18 0.554,-0.4 0,-0.22 0.36,-0.4 0.8,-0.4 0.44,0 0.8,-0.18 0.8,-0.4 0,-0.22 0.371,-0.4 0.824,-0.4 0.527,0 0.719,-0.169 0.534,-0.468 -0.194,-0.315 -0.071,-0.384 0.376,-0.213 0.366,0.141 0.666,0.082 0.666,-0.132 0,-0.213 0.36,-0.387 0.8,-0.387 0.44,0 0.8,-0.18 0.8,-0.4 0,-0.22 0.135,-0.379 0.3,-0.353 0.817,0.129 1.3,-0.103 1.3,-0.624 0,-0.362 0.299,-0.52 0.8,-0.423 0.522,0.101 0.8,-0.061 0.8,-0.466 0,-0.386 0.226,-0.533 0.6,-0.389 0.33,0.126 0.6,0.056 0.6,-0.158 0,-0.213 0.3,-0.387 0.667,-0.387 0.366,0 0.555,-0.111 0.419,-0.248 -0.484,-0.484 1.989,-2.148 3.209,-2.158 0.537,-0.005 0.578,-0.086 0.173,-0.344 -0.377,-0.238 -0.172,-0.409 0.7,-0.584 0.677,-0.135 1.232,-0.478 1.232,-0.762 0,-0.283 0.675,-0.819 1.5,-1.19 0.825,-0.371 2.109,-1.224 2.854,-1.895 0.745,-0.67 1.473,-1.219 1.617,-1.219 0.144,0 0.93,-0.63 1.746,-1.399 0.815,-0.77 1.483,-1.213 1.483,-0.984 0,0.238 0.237,0.195 0.558,-0.101 0.307,-0.284 0.487,-0.633 0.4,-0.777 -0.086,-0.144 0.383,-0.449 1.042,-0.679 0.66,-0.23 1.2,-0.528 1.2,-0.663 0,-0.134 -0.208,-0.116 -0.462,0.041 -0.279,0.173 -0.353,0.11 -0.187,-0.159 0.151,-0.244 0.539,-0.343 0.862,-0.219 0.371,0.143 0.587,-0.019 0.587,-0.441 0,-0.366 0.185,-0.552 0.411,-0.412 0.418,0.258 2.789,-1.994 2.789,-2.649 0,-0.197 0.291,-0.358 0.647,-0.358 0.356,0 1.184,-0.585 1.84,-1.3 0.656,-0.715 1.072,-1.03 0.923,-0.7 -0.176,0.392 -0.072,0.36 0.3,-0.094 0.313,-0.381 0.686,-0.576 0.83,-0.433 0.143,0.143 0.26,0.083 0.26,-0.134 0,-0.476 2.149,-2.939 2.564,-2.939 0.161,0 0.563,-0.27 0.893,-0.6 0.33,-0.33 0.484,-0.6 0.343,-0.6 -0.141,0 0.013,-0.27 0.343,-0.6 0.33,-0.33 0.803,-0.6 1.052,-0.6 0.249,0 0.341,-0.18 0.205,-0.4 -0.136,-0.22 -0.073,-0.4 0.14,-0.4 0.518,0 6.06,-5.527 6.06,-6.043 0,-0.222 0.18,-0.293 0.4,-0.157 0.22,0.136 0.4,0.044 0.4,-0.205 0,-0.249 0.27,-0.722 0.6,-1.052 0.33,-0.33 0.6,-0.484 0.6,-0.343 0,0.141 0.27,-0.013 0.6,-0.343 0.33,-0.33 0.6,-0.732 0.6,-0.893 0,-0.415 2.463,-2.564 2.939,-2.564 0.217,0 0.289,-0.105 0.161,-0.233 -0.128,-0.129 0.112,-0.624 0.533,-1.1 1.751,-1.98 1.967,-2.294 1.967,-2.867 0,-0.33 0.315,-0.601 0.7,-0.601 0.716,-10e-4 2.381,-2.135 2.2,-2.82 -0.055,-0.208 0.189,-0.379 0.543,-0.379 0.401,0 0.558,-0.221 0.417,-0.587 -0.124,-0.323 -0.025,-0.711 0.219,-0.862 0.269,-0.166 0.332,-0.092 0.159,0.187 -0.157,0.254 -0.175,0.462 -0.041,0.462 0.135,0 0.433,-0.54 0.663,-1.2 0.23,-0.659 0.535,-1.128 0.679,-1.042 0.144,0.087 0.493,-0.093 0.777,-0.4 0.296,-0.321 0.339,-0.558 0.101,-0.558 -0.229,0 0.304,-0.764 1.184,-1.698 0.879,-0.934 1.599,-1.859 1.599,-2.057 0,-0.197 0.54,-0.874 1.2,-1.505 0.66,-0.631 1.2,-1.29 1.2,-1.464 0,-0.759 1.045,-2.47 1.51,-2.473 0.28,-0.002 0.621,-0.558 0.756,-1.235 0.146,-0.73 0.364,-1.043 0.534,-0.768 0.172,0.279 0.378,0.01 0.515,-0.673 0.253,-1.265 1.621,-3.057 2.026,-2.653 0.142,0.143 0.259,-0.041 0.259,-0.407 0,-0.367 0.174,-0.667 0.387,-0.667 0.214,0 0.284,-0.27 0.158,-0.6 -0.144,-0.374 0.003,-0.6 0.389,-0.6 0.405,0 0.567,-0.278 0.466,-0.8 -0.099,-0.513 0.061,-0.8 0.447,-0.8 0.33,0 0.489,-0.18 0.353,-0.4 -0.136,-0.22 -0.046,-0.4 0.2,-0.4 0.246,0 0.336,-0.18 0.2,-0.4 -0.136,-0.22 -0.057,-0.4 0.176,-0.4 0.233,0 0.424,-0.36 0.424,-0.8 0,-0.44 0.191,-0.8 0.424,-0.8 0.233,0 0.312,-0.18 0.176,-0.4 -0.136,-0.22 -0.057,-0.4 0.176,-0.4 0.233,0 0.424,-0.36 0.424,-0.8 0,-0.44 0.18,-0.8 0.4,-0.8 0.22,0 0.4,-0.36 0.4,-0.8 0,-0.44 0.18,-0.8 0.4,-0.8 0.22,0 0.4,-0.36 0.4,-0.8 0,-0.44 0.18,-0.8 0.4,-0.8 0.22,0 0.403,-0.405 0.406,-0.9 0.005,-0.728 0.08,-0.785 0.394,-0.3 0.314,0.485 0.389,0.428 0.394,-0.3 0.003,-0.495 0.141,-0.901 0.306,-0.903 0.424,-0.005 1.299,-1.998 1.306,-2.977 0.005,-0.676 0.074,-0.715 0.394,-0.22 0.316,0.489 0.389,0.44 0.394,-0.267 0.003,-0.476 0.231,-0.957 0.506,-1.068 0.4,-0.161 0.4,-0.208 0,-0.233 -0.275,-0.018 -0.5,-0.242 -0.5,-0.499 0,-0.256 0.109,-0.357 0.243,-0.224 0.353,0.354 1.287,-0.627 1.089,-1.143 -0.093,-0.241 0.11,-0.669 0.45,-0.951 0.34,-0.282 0.618,-0.853 0.618,-1.269 0,-0.416 0.168,-1.069 0.374,-1.451 0.205,-0.382 0.604,-1.267 0.885,-1.966 0.281,-0.699 0.608,-1.211 0.726,-1.138 0.118,0.073 0.25,-0.483 0.292,-1.235 0.042,-0.752 0.359,-1.649 0.704,-1.994 0.344,-0.344 0.541,-0.765 0.437,-0.934 -0.105,-0.169 0.179,-0.703 0.631,-1.188 0.451,-0.485 0.727,-1.125 0.613,-1.422 -0.114,-0.297 0.045,-0.873 0.353,-1.279 0.308,-0.407 0.565,-1.155 0.572,-1.663 0.008,-0.526 0.189,-0.814 0.423,-0.67 0.225,0.139 0.384,0.105 0.353,-0.076 -0.206,-1.184 0.09,-2.544 0.499,-2.292 0.256,0.158 0.354,0.112 0.22,-0.105 -0.132,-0.215 -0.01,-0.835 0.272,-1.379 0.282,-0.544 0.543,-1.251 0.58,-1.571 0.243,-2.109 0.604,-3.621 0.91,-3.81 0.196,-0.121 0.356,-0.66 0.356,-1.197 0,-0.537 0.225,-0.979 0.5,-0.982 0.339,-0.004 0.307,-0.143 -0.1,-0.431 -0.452,-0.319 -0.476,-0.474 -0.1,-0.627 0.275,-0.111 0.5,-0.782 0.5,-1.489 0,-0.708 0.169,-1.458 0.375,-1.667 0.207,-0.209 0.44,-0.868 0.519,-1.465 0.078,-0.597 0.269,-1.212 0.424,-1.367 0.155,-0.155 0.282,-0.691 0.282,-1.191 0,-0.5 0.18,-1.021 0.4,-1.157 0.586,-0.362 0.49,-1.098 -0.1,-0.765 -0.4,0.226 -0.4,0.175 0,-0.256 0.275,-0.297 0.5,-0.848 0.5,-1.226 0,-0.377 0.225,-0.777 0.5,-0.888 0.4,-0.161 0.4,-0.208 0,-0.233 -0.275,-0.018 -0.5,-0.313 -0.5,-0.656 0,-0.343 0.18,-0.512 0.4,-0.376 0.232,0.144 0.425,-0.308 0.459,-1.076 0.11,-2.448 0.14,-2.651 0.441,-2.955 0.165,-0.166 0.3,-0.686 0.3,-1.156 0,-0.469 0.225,-1.095 0.5,-1.392 0.4,-0.431 0.4,-0.482 0,-0.256 -0.548,0.309 -0.707,-0.39 -0.165,-0.725 0.184,-0.113 0.359,-0.865 0.389,-1.67 0.03,-0.804 0.207,-1.667 0.392,-1.916 0.185,-0.25 0.373,-1.52 0.417,-2.822 0.045,-1.302 0.266,-2.59 0.491,-2.861 0.286,-0.345 0.254,-0.556 -0.107,-0.701 -0.396,-0.158 -0.4,-0.214 -0.017,-0.238 0.589,-0.038 0.686,-1.232 0.1,-1.232 -0.22,0 -0.4,-0.145 -0.4,-0.322 0,-0.42 -99.066,-99.426 -99.702,-99.642 -0.292,-0.099 -0.248,0.095 0.109,0.488 M 155.607,331.8 c 18.138,18.15 33.026,33 33.085,33 0.06,0 0.108,-9.09 0.108,-20.2 v -20.2 h -1.92 c -1.056,0 -2.091,-0.165 -2.3,-0.366 -0.209,-0.202 -1.46,-0.46 -2.78,-0.574 -6.746,-0.583 -20.198,-3.884 -25.8,-6.33 -0.942,-0.412 -1.526,-0.644 -3.7,-1.473 -0.495,-0.189 -1.682,-0.729 -2.638,-1.2 -0.956,-0.471 -1.991,-0.857 -2.3,-0.857 -0.309,0 -0.562,-0.18 -0.562,-0.4 0,-0.22 -0.36,-0.4 -0.8,-0.4 -0.44,0 -0.8,-0.18 -0.8,-0.4 0,-0.22 -0.36,-0.4 -0.8,-0.4 -0.44,0 -0.8,-0.18 -0.8,-0.4 0,-0.22 -0.36,-0.4 -0.8,-0.4 -0.44,0 -0.8,-0.18 -0.8,-0.4 0,-0.22 -0.345,-0.4 -0.767,-0.4 -0.421,0 -0.826,-0.135 -0.9,-0.3 -0.167,-0.376 -2.297,-1.675 -3.233,-1.971 -0.385,-0.122 -0.7,-0.381 -0.7,-0.576 0,-0.194 -0.193,-0.353 -0.428,-0.353 -0.235,0 -1.213,-0.54 -2.172,-1.2 -0.959,-0.66 -1.844,-1.2 -1.967,-1.2 -0.311,0 -6.663,-4.412 -7.608,-5.284 -0.427,-0.394 -0.96,-0.716 -1.185,-0.716 -0.226,0 14.43,14.85 32.567,33" style="fill:#4c3c84;fill-rule:evenodd;stroke:none" />
						<path id="path4" d="m 190.8,75.656 c -6.222,0.389 -11.362,1.095 -16.9,2.323 -1.045,0.231 -2.665,0.587 -3.6,0.791 -1.976,0.43 -5.923,1.521 -8.5,2.35 -27.59,8.872 -51.705,27.629 -67.469,52.48 -5.581,8.798 -11.384,21.555 -13.964,30.7 -0.202,0.715 -0.561,1.975 -0.797,2.8 -0.237,0.825 -0.597,2.265 -0.8,3.2 -0.204,0.935 -0.56,2.555 -0.791,3.6 -1.568,7.072 -2.878,18.892 -2.915,26.3 -0.025,4.951 0.6,13.932 1.016,14.6 0.262,0.421 0.313,0.235 0.172,-0.623 -2.375,-14.436 1.75,-45.62 7.802,-58.977 0.424,-0.935 0.807,-1.864 1.567,-3.8 0.662,-1.686 5.375,-11.266 6.198,-12.6 3.636,-5.892 5.424,-8.648 7.525,-11.6 1.33,-1.87 2.523,-3.49 2.651,-3.6 0.128,-0.11 0.647,-0.74 1.153,-1.4 4.193,-5.465 13.587,-14.859 19.052,-19.052 0.66,-0.506 1.29,-1.025 1.4,-1.153 0.11,-0.128 1.73,-1.321 3.6,-2.651 2.952,-2.101 5.708,-3.889 11.6,-7.525 1.316,-0.812 10.735,-5.448 12.7,-6.251 1.955,-0.799 3.135,-1.29 3.9,-1.623 6.603,-2.877 21.887,-6.449 32.4,-7.574 4.869,-0.52 23.221,-0.277 28,0.372 9.131,1.24 23.077,4.728 28.8,7.204 0.44,0.19 1.25,0.526 1.8,0.746 2.177,0.871 3.191,1.335 8.2,3.753 2.86,1.38 5.83,2.898 6.6,3.373 5.892,3.636 8.648,5.424 11.6,7.525 1.87,1.33 3.49,2.52 3.6,2.643 0.11,0.123 1.19,1.03 2.4,2.014 10.354,8.425 22.021,21.975 27.898,32.399 0.434,0.77 1.261,2.21 1.838,3.2 6.601,11.327 11.948,27.063 14.205,41.8 4.097,26.754 -1.545,57.875 -14.358,79.2 -0.66,1.1 -1.319,2.27 -1.464,2.6 -5.185,11.86 -31.859,38.534 -43.719,43.719 -0.33,0.145 -1.5,0.804 -2.6,1.464 -12.263,7.368 -28.829,12.668 -47.2,15.099 l -2.4,0.318 -0.003,38.2 -0.003,38.2 0.105,-37.867 0.105,-37.868 2.018,-0.432 c 1.109,-0.238 2.636,-0.433 3.392,-0.433 0.756,0 2.142,-0.173 3.08,-0.384 0.938,-0.211 2.786,-0.584 4.106,-0.83 1.32,-0.245 3.03,-0.601 3.8,-0.791 0.77,-0.189 2.3,-0.557 3.4,-0.816 13.061,-3.077 32.081,-11.973 42,-19.643 11.777,-9.108 22.863,-20.094 27.278,-27.031 0.387,-0.608 0.813,-1.195 0.946,-1.305 0.544,-0.447 5.167,-7.64 7.12,-11.077 5.328,-9.374 10.3,-21.658 12.435,-30.723 0.259,-1.1 0.627,-2.63 0.816,-3.4 0.19,-0.77 0.539,-2.435 0.775,-3.7 0.237,-1.265 0.607,-3.245 0.823,-4.4 1.459,-7.793 1.694,-26.756 0.446,-35.9 -0.641,-4.69 -2.244,-12.736 -3.209,-16.1 -0.236,-0.825 -0.592,-2.085 -0.789,-2.8 C 312.609,139.267 290.744,109.117 270.777,97.323 270.13,96.94 269.6,96.486 269.6,96.314 269.6,96.141 269.412,96 269.182,96 c -0.23,0 -1.715,-0.859 -3.3,-1.91 -1.585,-1.05 -3.422,-2.175 -4.082,-2.499 -0.66,-0.324 -1.29,-0.693 -1.4,-0.82 -1.179,-1.354 -18.802,-8.802 -24.6,-10.396 -0.66,-0.181 -1.92,-0.534 -2.8,-0.783 -0.88,-0.249 -2.365,-0.619 -3.3,-0.822 -0.935,-0.204 -2.555,-0.56 -3.6,-0.791 -10.51,-2.33 -22.527,-3.121 -35.3,-2.323 M 76.4,217.91 c 0,1.343 0.163,2.543 0.362,2.667 0.334,0.206 0.126,-4.553 -0.216,-4.944 -0.08,-0.091 -0.146,0.933 -0.146,2.277 m 0.8,5 c 0,1.013 0.178,1.953 0.395,2.087 0.252,0.156 0.304,-0.452 0.144,-1.676 C 77.407,220.79 77.2,220.632 77.2,222.91 m 0.806,3.723 c 0.003,0.642 0.19,1.437 0.415,1.767 0.293,0.43 0.333,0.146 0.141,-1 -0.332,-1.984 -0.564,-2.304 -0.556,-0.767 m 0.834,3.643 c -0.022,0.702 0.14,1.388 0.36,1.524 0.46,0.284 0.46,-0.364 0,-1.8 -0.306,-0.955 -0.322,-0.943 -0.36,0.276 m 0.788,3 c -0.015,0.592 0.152,1.188 0.372,1.324 0.478,0.295 0.478,-0.489 0,-1.6 -0.307,-0.714 -0.347,-0.685 -0.372,0.276 m 0.8,2.8 c -0.015,0.592 0.152,1.188 0.372,1.324 0.478,0.295 0.478,-0.489 0,-1.6 -0.307,-0.714 -0.347,-0.685 -0.372,0.276 m 0.784,2.324 c 0,0.33 0.175,0.87 0.388,1.2 0.345,0.533 0.388,0.533 0.388,0 0,-0.33 -0.175,-0.87 -0.388,-1.2 -0.345,-0.533 -0.388,-0.533 -0.388,0 m 0.815,2.273 c -0.103,1.799 7.926,19.684 9.574,21.327 0.11,0.11 0.466,0.74 0.791,1.4 1.573,3.199 8.19,12.511 12.364,17.4 5.649,6.618 19.644,19.541 19.644,18.14 0,-0.195 -0.429,-0.621 -0.954,-0.947 -3.685,-2.288 -11.715,-9.956 -18.648,-17.806 C 97.107,271.479 88.461,256.826 83.8,244.6 c -1.492,-3.913 -1.742,-4.467 -1.773,-3.927 m 42.774,58.801 c 0,0.18 0.765,0.826 1.7,1.438 0.934,0.611 2.141,1.421 2.682,1.8 0.541,0.378 0.865,0.496 0.722,0.261 -0.395,-0.644 -5.105,-3.873 -5.104,-3.499 m 5.599,4.054 c 0,0.206 0.54,0.599 1.2,0.872 0.66,0.273 1.2,0.655 1.2,0.849 0,0.193 0.197,0.351 0.438,0.351 0.241,0 0.916,0.339 1.5,0.753 2.755,1.953 15.538,8.477 17.662,9.014 0.55,0.139 0.19,-0.139 -0.8,-0.618 -7.776,-3.763 -10.87,-5.326 -12.6,-6.366 -1.1,-0.661 -2.27,-1.318 -2.6,-1.461 -0.33,-0.143 -1.59,-0.917 -2.8,-1.721 -3.019,-2.006 -3.2,-2.1 -3.2,-1.673 M 158,317.6 c 0.33,0.213 0.87,0.388 1.2,0.388 0.533,0 0.533,-0.043 0,-0.388 -0.33,-0.213 -0.87,-0.388 -1.2,-0.388 -0.533,0 -0.533,0.043 0,0.388 m 2,0.554 c 0,0.258 3.902,1.447 4.675,1.424 0.399,-0.011 -0.355,-0.369 -1.675,-0.794 -2.446,-0.787 -3,-0.903 -3,-0.63 m 5.771,1.8 c 0.223,0.36 1.709,0.736 4.229,1.069 0.77,0.102 0.14,-0.172 -1.4,-0.608 -3.306,-0.937 -3.102,-0.904 -2.829,-0.461 m 6.013,1.62 c 0.145,0.235 0.913,0.426 1.706,0.426 1.765,0 1.613,-0.203 -0.429,-0.572 -1.049,-0.19 -1.456,-0.143 -1.277,0.146 m 3.53,0.671 c 0.292,0.294 2.698,0.73 6.486,1.174 0.88,0.103 2.814,0.382 4.298,0.62 l 2.698,0.433 0.105,37.864 0.105,37.864 -0.003,-38.2 -0.003,-38.2 -3.4,-0.314 c -1.87,-0.173 -4.3,-0.482 -5.4,-0.688 -3.797,-0.709 -5.199,-0.868 -4.886,-0.553" style="fill:#98518e;fill-rule:evenodd;stroke:none" />
					</g>
				</svg>
			</div>
			<div class="login100-more" style="background-image: url('../dist/img/bc4.jpg');"></div>

			<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50" style="background-image: url('../dist/img/b.jpg');">
				<form action='' method='post' class="validate-form">
					<span class="animated flipInX login100-form-title p-b-59">
						<?php echo	$namaaplikasi; ?>
					</span>

					<div class="wrap-input100 validate-input" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Username...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="*************">
						<span class="focus-input100"></span>
					</div>



					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button name='submit' class="login100-form-btn">
								Login Masuk
							</button>
						</div>


					</div>
				</form>

			</div>

		</div>
	</div>

	<script src='../plugins/jQuery/jquery-3.2.1.min.js'></script>
	<script src='../dist/bootstrap/js/bootstrap.min.js'></script>

	<script src="../plugins/jQuery/main.js"></script>

</body>

</html>