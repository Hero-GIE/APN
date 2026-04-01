@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Email Signature</h1>
            <p class="text-gray-600 mb-6">Copy the HTML below and paste it into your email signature settings.</p>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h2 class="font-semibold text-gray-700 mb-3">Preview:</h2>
                <div class="border border-gray-200 rounded-lg p-4 bg-white">
                    {!! $signatureHtml !!}
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="font-semibold text-gray-700 mb-3">HTML Code:</h2>
                <div class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto">
                    <code id="signatureCode" class="text-sm whitespace-pre-wrap break-all">{{ htmlspecialchars($signatureHtml) }}</code>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button onclick="copySignature()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Copy HTML
                </button>
                <a href="{{ route('member.badges') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Back to Badges
                </a>
            </div>
            
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">How to add to your email signature:</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li><strong>Gmail:</strong> Settings → See all settings → Signature → Create new → Paste HTML (use "Insert" → "Insert HTML")</li>
                    <li><strong>Outlook:</strong> File → Options → Mail → Signatures → New → Paste HTML</li>
                    <li><strong>Apple Mail:</strong> Preferences → Signatures → Add signature → Paste HTML (use "Format" → "Make Plain Text" first)</li>
                    <li><strong>Yahoo Mail:</strong> Settings → More Settings → Mailboxes → Signature → Paste HTML</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function copySignature() {
    const codeElement = document.getElementById('signatureCode');
    const textToCopy = codeElement.textContent || codeElement.innerText;
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        const btn = event.target;
        const originalText = btn.textContent;
        btn.textContent = 'Copied!';
        btn.classList.add('bg-green-600');
        
        setTimeout(() => {
            btn.textContent = originalText;
            btn.classList.remove('bg-green-600');
        }, 2000);
    });
}
</script>
@endsection