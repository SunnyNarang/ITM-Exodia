package com.ExodiaSolutions.sunnynarang.itmexodia.guest;

import android.graphics.Typeface;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.TextView;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.ExodiaSolutions.sunnynarang.itmexodia.students.Subjects;

public class AboutInstitute extends AppCompatActivity {
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                AboutInstitute.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_about_institute);
        ActionBar actionBar = getSupportActionBar();
       // actionBar.hide();
        actionBar.setTitle("About ITM-GOI");

        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        TextView textView = (TextView) findViewById(R.id.guest_headAbout);
        Typeface type1 = Typeface.createFromAsset(getAssets(),"fonts/TitilliumWeb-Light.ttf");
        textView.setTypeface(type1);
        Typeface type = Typeface.createFromAsset(getAssets(),"fonts/Lato-Regular.ttf");
        textView.setTypeface(type1);
        TextView tv= (TextView) findViewById(R.id.guest_abouttv);
        tv.setTypeface(type);
    }
}
