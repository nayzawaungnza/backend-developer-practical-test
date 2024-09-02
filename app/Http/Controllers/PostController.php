<?php

namespace App\Http\Controllers;

use App\Exceptions\UserAlreadyLikedPostException;
use App\Exceptions\UserLikeOwnPostException;
use App\Http\Requests\PostToggleReactionRequest;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function list()
    {
        $posts = Post::with(['tags','author'])->withCount('likes')->paginate();

        return new PostCollection($posts);
    }

    public function toggleReaction(PostToggleReactionRequest $request)
    {
        try {
            $post = Post::with(['likes' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->findOrFail($request->validated('post_id'));
            
            if (Gate::denies('like-post', $post)) {
                throw new UserLikeOwnPostException();
            }

            $hasLiked = $post->likes->isNotEmpty();

            if ($hasLiked) {
                if ($request->boolean('like')) {
                    throw new UserAlreadyLikedPostException();
                }

                $post->likes()->where('user_id', Auth::id())->delete();

                return response()->json([
                    'status'  => Response::HTTP_OK,
                    'message' => 'You unliked this post successfully',
                ]);
            }

            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'status'  => Response::HTTP_OK,
                'message' => 'You liked this post successfully',
            ]);
            
        } catch (UserLikeOwnPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'You cannot like your post',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UserAlreadyLikedPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'You already liked this post',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'model not found',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}