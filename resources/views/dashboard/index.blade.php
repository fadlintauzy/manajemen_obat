<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Simple Login System</title>
    @vite('resources/css/app.css')
  </head>
  <body class="min-h-screen bg-[#0f2027] font-sans text-white antialiased">
    <div class="relative min-h-screen overflow-hidden">
      <div class="pointer-events-none absolute inset-0 -z-10 bg-[linear-gradient(135deg,#0f2027,#203a43,#2c5364)]"></div>

      <nav class="flex items-center justify-between border-b border-white/10 bg-white/5 px-6 py-4 backdrop-blur">
        <div class="flex items-center gap-3">
          <span class="text-2xl">🚀</span>
          <div>
            <p class="text-lg font-semibold">LoginHub</p>
            <p class="text-xs uppercase tracking-[0.4em] text-white/60">Dashboard</p>
          </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-4">
          @csrf
          <span class="hidden text-sm text-white/80 sm:inline">{{ $username }}</span>
          <button type="submit" class="rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold shadow hover:bg-red-400">
            Logout
          </button>
        </form>
      </nav>

      <main class="mx-auto flex w-full max-w-5xl flex-col gap-8 px-4 py-10">
        <section class="text-center">
          <p class="text-sm uppercase tracking-[0.5em] text-white/60">Simple Login System</p>
          <h1 class="mt-4 text-4xl font-bold">Selamat Datang, {{ $username }}! 👋</h1>
          <p class="mt-2 text-white/80">Anda berhasil login menggunakan akun internal.</p>
        </section>

        <section class="grid gap-6 md:grid-cols-2">
          <article class="rounded-3xl border border-white/15 bg-white/10 p-8 shadow-2xl backdrop-blur">
            <p class="text-sm uppercase tracking-[0.4em] text-white/60">Profil</p>
            <div class="mt-6 flex flex-col items-center text-center">
              <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-[#667eea] to-[#764ba2] text-4xl font-bold">
                {{ strtoupper(substr($username, 0, 1)) }}
              </div>
              <p class="mt-4 text-2xl font-semibold">{{ $username }}</p>
              <p class="mt-2 inline-flex items-center rounded-full bg-green-500/20 px-4 py-1 text-sm text-green-200">
                Status: Aktif
              </p>
            </div>
          </article>

          <article class="rounded-3xl border border-white/15 bg-white/5 p-8 shadow-2xl backdrop-blur">
            <p class="text-sm uppercase tracking-[0.4em] text-white/60">Informasi Sistem</p>
            <ul class="mt-6 space-y-3 text-white/80">
              <li class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                <span>Framework</span>
                <span class="font-semibold text-red-300">Laravel 11</span>
              </li>
              <li class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                <span>PHP Version</span>
                <span class="font-semibold text-blue-300">8.4</span>
              </li>
              <li class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                <span>Database</span>
                <span class="font-semibold text-yellow-300">MySQL</span>
              </li>
              <li class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                <span>CSS Framework</span>
                <span class="font-semibold text-cyan-300">Tailwind</span>
              </li>
              <li class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                <span>Server</span>
                <span class="font-semibold text-purple-300">WAMP</span>
              </li>
            </ul>
          </article>
        </section>
      </main>
    </div>
  </body>
</html>
