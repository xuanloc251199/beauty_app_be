<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getCommentByProductId($productId)
    {
        $comments = Comment::where('product_id', $productId)->get();

        return response()->json($comments);
    }
}
