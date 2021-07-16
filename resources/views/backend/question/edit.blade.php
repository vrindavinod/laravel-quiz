@extends('backend.layouts.master')

    @section('title','Update quiz')

    @section('content')
    <div class="span9">
        <div class="content">

    @if(Session::has('message'))
        <div class="alert alert-success">{{Session::get('message')}}

        </div>
    @endif

            <form action="{{route('question.update',[$question->id])}}" method="POST">
            @csrf
            {{method_field('PUT')}}
            <div class="module">
                <div class="module-name">
                    <h3>Update Question</h3>
                </div>
                <div class="module-body">

                    <div class="control-group">

                        <label class="control-label">Choose Quiz</label>
                        <div class="controls">
                            <select name="quiz" class="span8">
                                @foreach(App\Models\Quiz::all() as $quiz)
                                <option value="{{$quiz->id}}"
                                @if($quiz->id==$question->quiz_id)selected
                                @endif    
                                >{{$quiz->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="control-label">Question Name</label>
                        <div class="controls">
                            <input type="text" name="question" class="span8" placeholder="name of a quiz" value="{{$question->question}}">

                            @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <label class="control-label">Options</label>
                        <div class="controls">
                            @foreach($question->answers as $key=>$answer)
                            <input type="text" name="options[]" class="span5" value="{{$answer->answer}}">
                            <input type="radio" name="correct_answer" value="{{$key}}" @if($answer->is_correct){{'checked'}}
                            @endif>
                            <span>Is correct answer</span>
                            @endforeach
                            </div>
                            @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        


                        <div class="controls">

                            <button type="submit" class="btn btn-success">Submit</button>

                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </div>

    @endsection