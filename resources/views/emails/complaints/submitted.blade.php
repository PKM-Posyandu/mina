<x-mail::message>
# Pengaduan Baru Masuk

Anda menerima pengaduan baru melalui formulir publik.

<x-mail::panel>
**Nama**: {{ $complaint->nama_lengkap }}  
**WhatsApp**: {{ $complaint->nomor_whatsapp }}  
**Kategori**: {{ $complaint->kategori_pengaduan }}  
**Alamat**: {{ $complaint->alamat_lengkap }} (RT {{ $complaint->rt }})
</x-mail::panel>

**Isi Pengaduan:**

{{ $complaint->isi_pengaduan }}

@if($buktiUrl)
<x-mail::button :url="$buktiUrl">
Lihat Bukti Lampiran
</x-mail::button>
@endif

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
