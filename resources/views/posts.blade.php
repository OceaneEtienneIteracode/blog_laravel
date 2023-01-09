 <x-layout> {{-- Laracast - Laravel 8 From Scratch E15 7:14 --}}
    @foreach($posts as $post)
        <article>
            <h1>
                <a href="/posts/{!! $post->slug !!}">
                    {!! $post->title !!}
                </a>
            </h1>

            <div>{!! $post->excerpt !!}</div>
        </article>
    @endforeach
</x-layout>


