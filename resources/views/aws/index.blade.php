<form action="{{route('aws.store')}}" method="POST" enctype="multipart/form-data">
	@csrf
	<input type="file" name="file">
	<button type="submit">Submit</button>
</form>