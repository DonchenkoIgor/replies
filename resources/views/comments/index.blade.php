@extends('layout.app')

@section('content')
    <style>
        .comment, .reply {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .comment-header h5, .reply-header h6 {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .comment-header, .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .comment p, .reply p {
            font-size: 1rem;
            color: #333;
        }

        .comment-header h5, .reply-header h6 {
            color: #007bff;
        }

        .comment-footer {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }

        .reply-form {
            padding: 15px;
            background-color: #fafafa;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .reply-form h6 {
            margin-bottom: 15px;
            color: #555;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn {
            border-radius: 20px;
        }

        .replies {
            margin-top: 20px;
            padding-left: 20px;
        }

        .replies h6 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .replies .reply {
            margin-top: 10px;
            background-color: #f1f1f1;
        }

        .replies .reply .reply-header {
            font-size: 0.95rem;
            color: #555;
        }

        .replies .reply p {
            font-size: 1rem;
            color: #444;
        }

        .reply-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .reply-btn:hover {
            background-color: #0056b3;
        }

        .no-replies {
            font-style: italic;
            color: #777;
        }
    </style>

    <div class="container">
        <h1 class="my-4">Comments</h1>

        {{-- Форма для добавления нового комментария --}}
        <div class="mb-4">
            <h4>Add a new comment</h4>
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Your name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your message</label>
                    <textarea class="form-control" id="message" name="message" rows="3" placeholder="Write your message here" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>

        {{-- Список комментариев --}}
        <h2>All Comments</h2>
        @foreach($comments as $comment)
            <div class="comment">
                <div class="comment-header">
                    <h5>{{ $comment->name }}</h5>
                    <small class="text-muted">{{ $comment->created_at->format('d M Y, H:i') }}</small>
                </div>
                <p>{{ $comment->message }}</p>

                {{-- Форма для ответа на комментарий --}}
                <div class="reply-form">
                    <h6>Reply to this comment</h6>
                    <form action="{{ route('comments.replyStore', $comment->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reply-name" class="form-label">Your name</label>
                            <input type="text" class="form-control" id="reply-name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="reply-message" class="form-label">Your reply</label>
                            <textarea class="form-control" id="reply-message" name="message" rows="3" placeholder="Write your reply here" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary">Submit Reply</button>
                    </form>
                </div>

                {{-- Список ответов на комментарий --}}
                @if($comment->replies->count() > 0)
                    <div class="replies">
                        <h6>Replies:</h6>
                        @foreach($comment->replies as $reply)
                            <div class="reply">
                                <div class="reply-header">
                                    <h6>{{ $reply->name }} replied:</h6>
                                    <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                                </div>
                                <p>{{ $reply->message }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="no-replies">No replies yet.</p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
