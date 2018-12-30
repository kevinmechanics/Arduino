package com.airduino.ph;

import android.content.Context;
import android.webkit.JavascriptInterface;
import android.widget.Toast;
import android.os.*;
import android.app.*;
import android.view.*;
import android.graphics.*;

public class WebAppInterface {
    Context mContext;

    WebAppInterface(Context c){
        mContext = c;
    }
	
    @JavascriptInterface
    public void showToast(String toast){
        Toast.makeText(mContext,toast,Toast.LENGTH_SHORT).show();
    }
	
	
}
