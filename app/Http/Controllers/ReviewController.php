<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Pemesanan;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function showReviewForm($booking_uuid)
    {
        $order = Pemesanan::with('jadwal.kelas.studio')->where('booking_uuid', $booking_uuid)->firstOrFail();

        return view('member.review.form', [
            'order' => $order,
            'title' => 'Review Kelas'
        ]);
    }

    public function submitReview(Request $request, $booking_uuid)
    {
        $request->validate([
            'review_rating' => 'required|integer|min:1|max:5',
            'review_komen' => 'nullable|string|max:255',
        ]);

        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();

        Review::create([
            'review_uuid' => (string) Str::uuid(),
            'jadwal_uuid' => $order->jadwal->jadwal_uuid,
            'booking_uuid' => $booking_uuid,
            'member_uuid' => $order->member_uuid,
            'review_rating' => $request->review_rating,
            'review_komen' => $request->review_komen,
            'review_date' => now()->toDateString(),
        ]);

        return redirect()->route('member.pesan')->with('success', 'Review berhasil disimpan!');
    }
}
