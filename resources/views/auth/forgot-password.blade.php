<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <label>Email</label>
    <input type="email" name="email" required>

    <button type="submit">Kirim Link Reset</button>
</form>
