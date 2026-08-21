<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message Details</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.contact-messages.index') }}"
               class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Messages
            </a>
        </div>

        <!-- Message Card -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $message->subject }}</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Received {{ $message->created_at->diffForHumans() }}
                            <span class="mx-2">•</span>
                            {{ $message->created_at->format('F j, Y, g:i a') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 text-xs rounded-full {{ !$message->status ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ !$message->status ? 'Unread' : 'Read' }}
                        </span>
                        <!-- Delete Form -->
                        <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this message?')"
                                    class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sender Info -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">From</label>
                        <div class="mt-1">
                            <p class="text-sm font-medium text-gray-900">{{ $message->name }}</p>
                            <a href="mailto:{{ $message->email }}" class="text-sm text-blue-600 hover:underline">
                                {{ $message->email }}
                            </a>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Phone</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $message->phone ?? 'Not provided' }}
                        </p>
                        @if($message->phone)
                            <a href="tel:{{ $message->phone }}" class="text-sm text-blue-600 hover:underline">
                                Call {{ $message->phone }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="px-6 py-6">
                <label class="text-xs font-medium text-gray-500 uppercase">Message</label>
                <div class="mt-3 bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">
                        {{ $message->message }}
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-wrap gap-3">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Reply via Email
                    </a>

                    @if(!$message->status)
                        <!-- Mark as Read Form -->
                        <form action="{{ route('admin.contact-messages.mark-read', $message->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Mark as Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
