import os, glob, re
paths = ['app/Http/Controllers/**/*.php', 'resources/views/**/*.blade.php', 'app/Exports/**/*.php']
files = []
for p in paths:
    files.extend(glob.glob(p, recursive=True))
for f in files:
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    new_content = re.sub(r'format\([\'"]d[-/]m[-/]Y[\'"]\)', "format('d-M-Y')", content)
    new_content = re.sub(r'date\([\'"]d[-/]m[-/]Y[\'"]', "date('d-M-Y'", new_content)
    if content != new_content:
        with open(f, 'w', encoding='utf-8') as file:
            file.write(new_content)
        print('Updated:', f)
