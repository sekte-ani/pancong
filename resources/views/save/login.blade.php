<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <title>Login</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
  </head>

  <body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
    @include('sweetalert::alert')
    <main class="mt-0 transition-all duration-200 ease-in-out">
      <section>
        <a href="/"><svg class="back-button m-3" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
          <path
              d="M20 36.6666C29.2048 36.6666 36.6667 29.2047 36.6667 19.9999C36.6667 10.7952 29.2048 3.33325 20 3.33325C10.7953 3.33325 3.33334 10.7952 3.33334 19.9999C3.33334 29.2047 10.7953 36.6666 20 36.6666Z"
              stroke="#383961" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M20 13.3333L13.3333 19.9999L20 26.6666" stroke="#383961" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          <path d="M26.6667 20H13.3333" stroke="#383961" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
        </svg></a>
        <div class="container">
          <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
            <div class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
              <div class="p-6 mb-0 text-center bg-white border-b-0 rounded-t-2xl">
                <h5>Log In</h5>
              </div>
              <div class="flex-auto p-6">
                <form role="form text-left" action="login" method="POST">
                  @csrf
                  <div class="mb-4">
                    <input type="email" name="email" class="text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-[#5e72e4] focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow @error('email') is-invalid @enderror" id="email" required value="{{ old('email') }}" placeholder="Email" aria-label="Email" aria-describedby="email-addon" />
                  </div>
                  <div class="mb-4">
                    <input type="password" name="password" class="text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-[#5e72e4] focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow @error('password') is-invalid @enderror" id="password" required value="{{ old('password') }}" placeholder="Password" aria-label="Password" aria-describedby="password-addon" />
                  </div>
                  <div class="text-center">
                    <button type="submit" class="inline-block w-full px-6 py-3 mt-6 mb-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-md leading-normal text-xs ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Sign in</button>
                  </div>
                  <p class="mt-4 mb-0 leading-normal text-sm">Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-slate-700">Register</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
  <!-- main script file  -->
  <script src="{{ asset('assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}" async></script>
</html>
