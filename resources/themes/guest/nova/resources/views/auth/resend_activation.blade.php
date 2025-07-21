<section class="relative w-screen min-h-screen flex items-stretch overflow-hidden bg-white overflow-x-hidden">

    @include("partials/login-screen", ["name" => __("Resend Activation Email")])

    <div class="flex flex-col justify-center flex-1 px-8 py-16 bg-blueGray-100 z-10" style="background-image: url({{ theme_public_asset('images/pattern-light-big.svg') }}); background-position: center;">
        <form class="actionForm max-w-md mx-auto w-full space-y-5" action="{{ module_url('do_resend_activation') }}" method="POST">

			<div>
			    <label for="email" class="block text-gray-700 font-semibold mb-2">{{ __("Email Address") }}</label>
			    <input type="email" id="email" name="email"
			        class="input input-bordered input-lg w-full px-4 py-3.5 text-gray-700 font-medium bg-white border border-gray-300 rounded-lg focus:ring focus:ring-indigo-300 outline-none"
			        placeholder="{{ __('Enter your email address') }}" required>
			</div>

			<div class="flex flex-wrap justify-between mb-4">
			    <div class="w-full">
			        <div class="flex items-center">
			            <input class="w-4 h-4" id="accept_terms" name="accept_terms" type="checkbox" value="1" required>
			            <label class="ml-2 text-gray-700 font-medium" for="accept_terms">
			                <span>{{ __("I agree to the") }}</span>
			                <a class="text-indigo-600 hover:text-indigo-700" href="#">{{ __("Terms & Conditions") }}</a>
			            </label>
			        </div>
			    </div>
			</div>

			<div class="mb-3">
                {!! Captcha::render(); !!}
            </div>

			<div class="msg-error mb-2"></div>

			<button type="submit"
			    class="mb-8 py-4 px-9 w-full text-white font-semibold border border-indigo-700 rounded-xl shadow-4xl focus:ring focus:ring-indigo-300 bg-indigo-600 hover:bg-indigo-700 transition ease-in-out duration-200">
			    {{ __("Resend Activation Email") }}
			</button>

		</form>

    </div>
</section>
