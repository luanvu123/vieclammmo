<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
            'donate_amount' => 'nullable|numeric|min:0'
        ]);

        // Get the authenticated customer
        $customer = Auth::guard('customer')->user();

        // Check if donation is valid
        $donateAmount = $request->input('donate_amount', 0);

        // Start a database transaction
        return DB::transaction(function () use ($customer, $validatedData, $donateAmount) {
            // Check if customer has enough balance
            if ($donateAmount > 0 && $customer->Balance < $donateAmount) {
                return back()->with('error', 'Số dư không đủ để thực hiện donate.');
            }

            // Get the post
            $post = Post::findOrFail($validatedData['post_id']);

            // Create comment
            $comment = new Comment([
                'post_id' => $validatedData['post_id'],
                'customer_id' => $customer->id,
                'content' => $validatedData['content'],
                'donate_amount' => $donateAmount
            ]);

            // If there's a donation
            if ($donateAmount > 0) {
                // Deduct from customer's balance
                $customer->Balance -= $donateAmount;
                $customer->save();

                // Add to post owner's balance
                $postOwner = $post->customer;
                $postOwner->Balance += $donateAmount;
                $postOwner->save();
            }

            // Save the comment
            $comment->save();

            return back()->with('success', 'Bình luận đã được gửi thành công.');
        });
    }
}

