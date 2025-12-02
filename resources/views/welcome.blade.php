<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Login System</title>
    @vite('resources/css/app.css')
  </head>
  <body class="relative min-h-screen overflow-hidden bg-[#0f2027] font-sans text-white antialiased">
    <div
      class="pointer-events-none absolute inset-0 -z-10 bg-[linear-gradient(135deg,#667eea,#764ba2,#f093fb,#4facfe)] bg-[length:300%_300%] opacity-90 animate-[pulse_12s_ease-in-out_infinite]"
      aria-hidden="true"
    ></div>
    <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-10">
      <div class="w-full max-w-lg rounded-3xl border border-white/20 bg-white/10 p-12 shadow-2xl backdrop-blur-xl transition duration-500 hover:border-white/30">
        <div class="text-center">
          <p class="text-sm uppercase tracking-[0.4em] text-white/70">Simple Login System</p>
          <h1 class="mt-2 text-4xl font-bold">Welcome Back</h1>
          <p class="mt-2 text-base text-white/80">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        @if ($errors->any() || session('error'))
          <div class="mt-6 rounded-xl border border-red-500/80 bg-red-500/20 p-4 text-red-100 shadow-lg" role="alert">
            <p class="font-semibold">Terjadi kesalahan:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
              @if (session('error'))
                <li>{{ session('error') }}</li>
              @endif
            </ul>
          </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
          @csrf
          <div class="space-y-6">
            <div>
              <label class="text-sm font-medium text-white" for="username">Username</label>
              <div class="relative mt-2">
                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-white/80">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A11 11 0 0112 15a11 11 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </span>
                <input
                  id="username"
                  name="username"
                  type="text"
                  required
                  minlength="3"
                  value="{{ old('username') }}"
                  placeholder="Masukkan username Anda"
                  class="w-full rounded-xl border border-white/30 bg-white/20 py-3 pl-12 pr-4 text-white placeholder:text-white/70 transition focus:border-white/60 focus:outline-none focus:ring-2 focus:ring-blue-300/40"
                />
              </div>
            </div>

            <div>
              <label class="text-sm font-medium text-white" for="password">Password</label>
              <div class="relative mt-2">
                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-white/80">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c1.657 0 3-1.343 3-3V6a3 3 0 10-6 0v2c0 1.657 1.343 3 3 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 11h14v9H5z" />
                  </svg>
                </span>
                <input
                  id="password"
                  name="password"
                  type="password"
                  required
                  minlength="6"
                  placeholder="Masukkan password Anda"
                  class="w-full rounded-xl border border-white/30 bg-white/20 py-3 pl-12 pr-4 text-white placeholder:text-white/70 transition focus:border-white/60 focus:outline-none focus:ring-2 focus:ring-blue-300/40"
                />
              </div>
            </div>
          </div>

          <button
            type="submit"
            class="w-full rounded-xl bg-gradient-to-r from-[#667eea] to-[#764ba2] px-6 py-3 text-center text-lg font-semibold shadow-lg transition hover:scale-[1.02] focus:outline-none focus-visible:ring-2 focus-visible:ring-white disabled:cursor-not-allowed disabled:opacity-70"
            data-loading-text="Memproses..."
          >
            Login
          </button>
        </form>

        
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        if (!form) return;
        form.addEventListener('submit', function () {
          const button = form.querySelector('button[type="submit"]');
          if (!button) return;
          const text = button.dataset.loadingText || 'Loading...';
          button.dataset.originalText = button.textContent;
          button.textContent = text;
          button.disabled = true;
        });
      });
    </script>
  </body>
</html>