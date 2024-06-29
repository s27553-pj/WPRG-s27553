<?php
session_start();

// Usuń wszystkie zmienne sesji
session_unset();

// Zniszcz sesję
session_destroy();

// Przekieruj użytkownika na stronę logowania lub inną docelową stronę
header('Location: ../index.html');
exit();
?>
<?php
