package com.ExodiaSolutions.sunnynarang.itmexodia.guest;

import android.content.Intent;
import android.net.Uri;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.SpannableString;
import android.text.style.UnderlineSpan;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

public class ContactUs extends AppCompatActivity {

    TextView iTextView;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                ContactUs.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_contact_us);

        iTextView = (TextView) findViewById(R.id.map_add);
        SpannableString spanStr = new SpannableString("ITM University, Jhansi Rd, Gwalior, Madhya Pradesh 475001");
        spanStr.setSpan(new UnderlineSpan(), 0, spanStr.length(), 0);
        iTextView.setText(spanStr);
        ActionBar actionBar = getSupportActionBar();
        // actionBar.hide();
        actionBar.setTitle("Contact Details");

        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
    }

    public void map(View v){
        Intent geoIntent = new Intent(Intent.ACTION_VIEW, Uri.parse("geo:0,0?q="
                +iTextView.getText().toString()));
        startActivity(geoIntent);
    }
}
