@extends('layouts.admin')

@section('title', 'Add Supplier')
@section('page_title', 'Register New Supplier')

@section('content')
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('admin.suppliers.index') }}"
            class="inline-flex items-center gap-2 text-sm font-bold text-stone-500 hover:text-stone-900 mb-6 transition-colors">
            <i class="ri-arrow-left-line"></i> Back to Network
        </a>

        <div class="bg-white rounded-xl border border-stone-300 shadow-sm overflow-hidden">
            <form action="{{ route('admin.suppliers.store') }}" method="POST" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Company
                                Name</label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                placeholder="e.g. Maison Noir Global"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Contact
                                Person</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                                placeholder="Full Name"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Email
                                Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="supplier@example.com"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Country / Region</label>
                            <input type="text" name="country" value="{{ old('country') }}" placeholder="e.g. France"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>
                    </div>

                    <!-- Contact & Address -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Phone
                                Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000"
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Website
                                (URL)</label>
                            <input type="url" name="website" value="{{ old('website') }}" placeholder="https://..."
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Office
                                Address</label>
                            <textarea name="address" rows="3" placeholder="Full company address..."
                                class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors resize-none">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <!-- Commercial Terms -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-stone-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Initial
                                    Rating (0-5)</label>
                                <input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating', 0) }}"
                                    class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Categories (Comma separated)</label>
                                <input type="text" name="categories" value="{{ old('categories') }}" placeholder="e.g. Fashion, Textiles"
                                    class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Brands (Comma separated)</label>
                                <input type="text" name="brands" value="{{ old('brands') }}" placeholder="e.g. Maison Noir, Zara"
                                    class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>

                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Payment
                                    Terms</label>
                                <input type="text" name="payment_terms" value="{{ old('payment_terms') }}"
                                    placeholder="e.g. Net 30"
                                    class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Lead
                                    Time</label>
                                <input type="text" name="lead_time" value="{{ old('lead_time') }}" placeholder="e.g. 2-3 Weeks"
                                    class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-500 uppercase tracking-widest mb-2">Internal
                            Procurement Notes</label>
                        <textarea name="notes" rows="4" placeholder="Any private details about this vendor..."
                            class="w-full bg-stone-50 border border-stone-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-amber-500 transition-colors resize-none">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-10 px-2 pt-6 border-t border-stone-100 flex items-center justify-end gap-12">
                    <a href="{{ route('admin.suppliers.index') }}"
                        class="px-6 py-3 text-sm font-bold text-stone-500 hover:text-stone-900 transition-colors">Cancel</a>
                    <button type="submit"
                        class="bg-stone-900 text-white px-6 py-3 rounded-lg text-sm font-bold hover:bg-stone-800 transition-all shadow-lg shadow-stone-200">
                        Register Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
