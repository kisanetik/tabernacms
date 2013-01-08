<script language='javascript' type='text/javascript'>
    var result = {
    {if isset($result->fileName)} fileName : '{$result->fileName}',{/if}
    {if isset($result->filePath)} filePath : '{$result->filePath}',{/if}
    {if isset($result->fileExtension)} fileExtension : '{$result->fileExtension}',{/if}
    {if isset($result->errors)} errors : '{$result->errors}',{/if}
    success : '{$result->success}'
    };
    window.top.window.{$uiName}.stopUpload(result);
</script>