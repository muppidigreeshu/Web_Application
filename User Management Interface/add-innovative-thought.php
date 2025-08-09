<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Innovative Thought</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Submit an Innovative Thought</h2>
        <form action="innovative-thoughts.php" method="POST">
            <div class="mb-3">
                <label for="thought_title" class="form-label">Thought Title</label>
                <input type="text" name="thought_title" id="thought_title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="submitted_by" class="form-label">Submitted By</label>
                <input type="text" name="submitted_by" id="submitted_by" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Thought</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
