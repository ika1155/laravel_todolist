<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            作業内容の修正
        </h2>
		<x-input-error class="mb-4" :messages="$errors->all()"/>
		<x-message :message="session('message')" />
    </x-slot>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mx-4 sm:p-8">
			<form method="post" action="{{route('todo_item.update', $todo_item)}}" enctype="multipart/form-data">
				@csrf
				@method('patch')
				<input type="hidden" name="from" value="edit">
				<div class="md:flex items-center mt-8">
					<div class="w-full flex">
					<label for="item_name" class="font-semibold leading-none mt-4">項目名</label>
					<input type="text" name="item_name" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" placeholder="Enter Title" value="{{old('item_name', $todo_item->item_name)}}">
					</div>
				</div>

				<div class="w-full flex">
					<label for="user_id" class="font-semibold leading-none mt-4">担当者</label>
					<select name="user_id">
						<option hidden>選択してください</option>
						@foreach ($users as $user)
							<option value="{{$user->id}}" @if (old('user_id', $todo_item->user_id) == $user->id) selected @endif>{{$user->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="w-full flex">
					<label for="expire_date" class="font-semibold leading-none mt-4">期限日</label>
					<div>
					<input type="date" name="expire_date" value="{{old('expire_date', $todo_item->expire_date)}}">
					</div>
				</div>

				<div class="w-full flex">
					<input  class="custom-select" type="checkbox" name="done" 
					@if (isset($todo_item->finished_date)) checked @endif>
					<label for="done" class="font-semibold leading-none mt-4">完了</label>
				</div>

				<x-primary-button class="mt-4">
					送信する
				</x-primary-button>
				
			</form>
		</div>
	</div>
</x-app-layout>