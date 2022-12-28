<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            作業登録
        </h2>
		<x-input-error class="mb-4" :messages="$errors->all()"/>
		<x-message :message="session('message')" />
    </x-slot>

	<div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm">
		<form method="post" action="{{route('todo_item.store')}}">
			@csrf
			<div class="form-group mb-6">
				<label for="item_name" class="form-label inline-block mb-2 text-gray-700">タスク</label>
				<input type="text" class="form-control
					block
					w-full
					px-3
					py-1.5
					text-base
					font-normal
					text-gray-700
					bg-white bg-clip-padding
					border border-solid border-gray-300
					rounded
					transition
					ease-in-out
					m-0
					focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="item_name"
				placeholder="Enter your task">
			</div>
		 	<div class="form-group mb-6">
				<label for="user_id" class="form-label inline-block mb-2 text-gray-700">担当者</label>
				<select class="form-select appearance-none
					block
					w-full
					px-3
					py-1.5
					text-base
					font-normal
					text-gray-700
					bg-white bg-clip-padding bg-no-repeat
					border border-solid border-gray-300
					rounded
					transition
					ease-in-out
					m-0
					focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="user_id">
					<option hidden>--選択してください--</option>
					@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->name}}</option>
					@endforeach
				</select>
		  	</div>
		  	<div class="form-group form-check mb-6">
				<label for="expire_date" class="form-label inline-block mb-2 text-gray-700">期日</label>
				<input type="date" class="form-control
					block
					w-full
					px-3
					py-1.5
					text-base
					font-normal
					text-gray-700
					bg-white bg-clip-padding
					border border-solid border-gray-300
					rounded
					transition
					ease-in-out
					m-0
					focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="expire_date">
			</div>
		  	<div class="form-group form-check mb-6">
				<input type="checkbox"
			  		class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
			  		name="done">
				<label class="form-check-label inline-block text-gray-800" for="done">完了</label>
		  	</div>
			<button type="submit" class="
				px-6
				py-2.5
				bg-blue-600
				text-white
				font-medium
				text-xs
				leading-tight
				uppercase
				rounded
				shadow-md
				hover:bg-blue-700 hover:shadow-lg
				focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
				active:bg-blue-800 active:shadow-lg
				transition
				duration-150
				ease-in-out">
				登録
			</button>
		</form>
	</div>

</x-app-layout>