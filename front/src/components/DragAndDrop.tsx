import React, { useState } from 'react';

//test ce drag and drop API

function DragAndDrop() {
  const [file, setFile] = useState<File | null>(null);
  const [isUploading, setIsUploading] = useState(false);

  const handleDrop = (event: React.DragEvent<HTMLDivElement>) => {
    event.preventDefault();
    const droppedFile = event.dataTransfer.files[0];
    setFile(droppedFile);
  };

  const handleUpload = async () => {
    if (!file) {
      return;
    }
    setIsUploading(true);
    const formData = new FormData();
    formData.append('file', file);
    try {
      const response = await fetch('https://your-api-url.com/upload', {
        method: 'POST',
        body: formData,
      });
      console.log('Upload successful');
    } catch (error) {
      console.error('Upload failed:', error);
    }
    setIsUploading(false);
  };

  return (
    <div onDrop={handleDrop} onDragOver={(event) => event.preventDefault()}>
      {isUploading ? (
        <p>Uploading...</p>
      ) : file ? (
        <button onClick={handleUpload}>Upload HTML</button>
      ) : (
        <p>Drop HTML file here to upload</p>
      )}
    </div>
  );
}
