<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../zaloguj.html');
    exit();
}

$role = $_SESSION['role'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id === null) {
    echo "ID użytkownika nie jest ustawione w sesji.";
    exit();
}

if ($role === 'admin' || $role === 'redaktor'): ?>
    <div class="row">
        <div class="col-md-8">
            <h2>Zmień hasło</h2>
            <form action="zmien_haslo.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> <!-- Ukryte pole z ID użytkownika -->
                <div class="mb-3">
                    <label for="obecne_haslo" class="form-label">Obecne hasło:</label>
                    <input type="password" class="form-control" id="obecne_haslo" name="obecne_haslo" required>
                </div>
                <div class="mb-3">
                    <label for="nowe_haslo" class="form-label">Nowe hasło</label>
                    <input type="password" class="form-control" id="nowe_haslo" name="nowe_haslo" required>
                </div>
                <button type="submit" class="btn btn-primary">Zmień hasło</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if ($role === 'admin'): ?>
    <div class="row mt-5">
        <div class="col-md-8">
            <h2>Dodaj użytkownika</h2>
            <form action="dodaj_uzytkownika.php" method="post">
                <div class="mb-3">
                    <label for="imie" class="form-label">Imię:</label>
                    <input type="text" class="form-control" id="imie" name="imie" required>
                </div>
                <div class="mb-3">
                    <label for="nazwisko" class="form-label">Nazwisko:</label>
                    <input type="text" class="form-control" id="nazwisko" name="nazwisko" required>
                </div>
                <div class="mb-3">
                    <label for="data_urodzenia" class="form-label">Data urodzenia:</label>
                    <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Hasło:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rola:</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="redaktor">Redaktor</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Dodaj użytkownika</button>
            </form>
        </div>
    </div>
<?php endif; ?>
