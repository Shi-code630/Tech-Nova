<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Contact Messages</h1>
            <a href="{{ route('contact.create') }}" class="text-blue-600 hover:text-blue-800 text-sm sm:text-base">
                + New Message
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-3 sm:p-4 text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">

           
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($messages as $message)
                        <tr class="{{ !$message->status ? 'bg-yellow-50' : '' }}">
                            <td class="px-4 lg:px-6 py-4 text-sm">#{{ $message->id }}</td>
                            <td class="px-4 lg:px-6 py-4 text-sm font-medium">{{ $message->name }}</td>
                            <td class="px-4 lg:px-6 py-4 text-sm break-all">{{ $message->email }}</td>
                            <td class="px-4 lg:px-6 py-4 text-sm">{{ $message->subject }}</td>
                            <td class="px-4 lg:px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full {{ !$message->status ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                    {{ !$message->status ? 'Unread' : 'Read' }}
                                </span>
                            </td>
                            <td class="px-4 lg:px-6 py-4 text-sm whitespace-nowrap">{{ $message->created_at->diffForHumans() }}</td>
                            <td class="px-4 lg:px-6 py-4 text-sm">
                                <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No messages found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <div class="md:hidden divide-y divide-gray-200">
                @forelse($messages as $message)
                <div class="p-4 {{ !$message->status ? 'bg-yellow-50' : '' }}">
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <span class="text-xs text-gray-400">#{{ $message->id }}</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ !$message->status ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                            {{ !$message->status ? 'Unread' : 'Read' }}
                        </span>
                    </div>

                    <p class="text-sm font-semibold text-gray-900">{{ $message->name }}</p>
                    <p class="text-sm text-gray-600 break-all">{{ $message->email }}</p>
                    <p class="text-sm text-gray-700 mt-1">{{ $message->subject }}</p>

                    <div class="flex justify-between items-center mt-3">
                        <span class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                        <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View →
                        </a>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-gray-500 text-sm">
                    No messages found.
                </div>
                @endforelse
            </div>

            @if($messages->hasPages())
                <div class="px-4 sm:px-6 py-3 border-t overflow-x-auto">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
