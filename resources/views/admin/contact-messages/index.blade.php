<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Contact Messages</h1>
            <a href="{{ route('contact.create') }}" class="text-blue-600 hover:text-blue-800">
                + New Message
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($messages as $message)
                    <tr class="{{ !$message->status ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 text-sm">#{{ $message->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium">{{ $message->name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $message->email }}</td>
                        <td class="px-6 py-4 text-sm">{{ $message->subject }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full {{ !$message->status ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                {{ !$message->status ? 'Unread' : 'Read' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $message->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-sm">
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

            @if($messages->hasPages())
                <div class="px-6 py-3 border-t">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
