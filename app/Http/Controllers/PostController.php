<?php 
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import the DB facade

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20048',
            'description' => 'required|string|max:500', 
        ]);

        $user = Auth::user();

        $imagePath = $request->file('image')->store('posts', 'public');

        DB::table('posts')->insert([
            'name' => $user->name, 
            'author' => $user->name, 
            'profile_pic' => $user->profile_pic, 
            'date' => now(), 
            'content' => $request->description, 
            'image' => $imagePath, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    public function index(Request $request)
    {
        $query = Post::query();

    if ($request->has('search') && $request->search) {
        $query->where('author', 'like', '%' . $request->search . '%');
    }

    $posts = $query->get();

    if ($request->ajax()) {
        return view('partial.posts', compact('posts'));
    }

    return view('dashboard', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $post->content = $request->description;

        // Handle image upload if there's a new image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
{
    $post->delete();

    return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
}
}
