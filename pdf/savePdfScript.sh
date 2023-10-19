# Set the directory path
directory="tmp_files"  # Replace with the actual directory path

# Use 'ls' to list files in the directory
files_in_directory=($directory/*)

# Check the number of files in the directory
file_count=${#files_in_directory[@]}

if [ $file_count -eq 1 ]; then
    # If there's only one file, extract its name
    file_name=$(basename "${files_in_directory[0]}")
elif [ $file_count -eq 0 ]; then
    echo "The directory is empty."
else
    echo "There is more than one file in the directory."
fi

curl -T $directory/$file_name -u hector:12 http://192.168.1.68/pdfs/$file_name
