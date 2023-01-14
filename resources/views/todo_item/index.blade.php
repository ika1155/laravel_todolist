@php
	$today =  date('Y-m-d');
@endphp

<x-app-layout>
    <x-slot name="header">
		<div class="flex justify-between">
			<h2 class="flex items-center font-semibold text-xl text-gray-800">
				作業一覧
			</h2>

			<div class=" rounded-lg p-3 w-2/4">
				<form method="GET" action="{{route('todo_item.index')}}">
					<div class="flex">
						<div class="flex w-10 items-center justify-center rounded-tl-lg rounded-bl-lg border-r border-gray-200 bg-white p-5">
							<svg viewBox="0 0 20 20" aria-hidden="true" class="pointer-events-none absolute w-5 fill-gray-500 transition">
								<path d="M16.72 17.78a.75.75 0 1 0 1.06-1.06l-1.06 1.06ZM9 14.5A5.5 5.5 0 0 1 3.5 9H2a7 7 0 0 0 7 7v-1.5ZM3.5 9A5.5 5.5 0 0 1 9 3.5V2a7 7 0 0 0-7 7h1.5ZM9 3.5A5.5 5.5 0 0 1 14.5 9H16a7 7 0 0 0-7-7v1.5Zm3.89 10.45 3.83 3.83 1.06-1.06-3.83-3.83-1.06 1.06ZM14.5 9a5.48 5.48 0 0 1-1.61 3.89l1.06 1.06A6.98 6.98 0 0 0 16 9h-1.5Zm-1.61 3.89A5.48 5.48 0 0 1 9 14.5V16a6.98 6.98 0 0 0 4.95-2.05l-1.06-1.06Z"></path>
							</svg>
						</div>
						<input type="text" name="keyword" value="{{$keyword}}" class="w-full bg-white pl-2 text-base font-semibold outline-0" >
						<input type="submit" value="検索" class="bg-blue-500 p-2 rounded-tr-lg rounded-br-lg text-white font-semibold hover:bg-blue-800 transition-colors">
					</div>
				</form>
			</div>
		</div>
		<x-message :message="session('message')" />
    </x-slot>
	
	<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
		<div class="flex flex-col shadow">		
			<div class="overflow-hidden">
				<table class="min-w-full">
					<thead class="bg-white border-b text-gray-900"">
						<tr>
							<th scope="col" class="text-sm font-medium px-6 py-4">
								作業名
							</th>
							<th scope="col" class="text-sm font-medium px-6 py-4">
								担当者
							</th>
							<th scope="col" class="text-sm font-medium px-6 py-4">
								期限日
							</th>
							<th scope="col" class="text-sm font-medium px-6 py-4">
								完了日
							</th>
							<th scope="col" class="text-sm font-medium px-6 py-4">
								操作
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($todo_items as $todo)
							<tr class="border-b transition duration-300 ease-in-out hover:bg-gray-100 @if ($todo->finished_date != null) bg-gray-100 @else bg-white @endif" align="center">
								<td class="text-sm @if ($today>$todo->expire_date && $todo->finished_date == null ) text-red-500 @endif px-6 py-4 whitespace-nowrap" align="left">
									@if ($todo->finished_date != null) <del> @endif
										{{$todo->item_name}}
									@if ($todo->finished_date != null) </del> @endif								
								</td>
								<td class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap  @if ($today>$todo->expire_date && $todo->finished_date == null ) text-red-500 @endif">
									@foreach ($users as $user)
											@if ($todo->user_id == $user->id)
												@if ($todo->finished_date != null) <del> @endif
												{{$user->name}}
												@if ($todo->finished_date != null) </del> @endif
											@endif
										@endforeach
								</td>
								<td class="text-sm @if ($today>$todo->expire_date && $todo->finished_date == null ) text-red-500 @endif px-6 py-4 whitespace-nowrap">
									@if ($todo->finished_date != null) <del> @endif
									{{$todo->expire_date}}
									@if ($todo->finished_date != null) </del> @endif
								</td>
								<td class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap  @if ($today>$todo->expire_date && $todo->finished_date == null ) text-red-500 @endif">
									@if ($todo->finished_date == null)
										未
									@else
										{{$todo->finished_date}}
									@endif
								</td>
								<td>
									<div style="display:inline-flex">
										<form method="post" action="{{route('todo_item.update', $todo)}}">
											@csrf
											@method('patch')
											<input type="hidden" name="from" value="index">
											<input type="hidden" name="done" value=true>
											<button class="bg-blue-500 hover:bg-blue-400 text-white rounded px-4 py-2">
												完了
											</button>
										</form>
										<a href="{{route('todo_item.edit', $todo)}}">
											<button class="bg-green-600 hover:bg-green-500 text-white rounded px-4 py-2">
												修正
											</button>
										</a>
										<form method="post" action="{{route('todo_item.destroy', $todo)}}">
											@csrf
											@method('delete')
											<button class="bg-red-500 hover:bg-red-400 text-white rounded px-4 py-2" onClick="return confirm('本当に削除しますか？');">
												削除
											</button>
										</form>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-app-layout>