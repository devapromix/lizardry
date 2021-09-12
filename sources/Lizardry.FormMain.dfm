object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 712
  ClientWidth = 1184
  Color = clBtnFace
  Constraints.MinHeight = 750
  Constraints.MinWidth = 1200
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Image1: TImage
      Width = 934
      Height = 712
      ExplicitWidth = 734
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 487
      inherited Label3: TLabel
        Top = 697
        Width = 248
        ExplicitTop = 472
      end
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Image1: TImage
      Width = 934
      Height = 712
      ExplicitWidth = 734
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 487
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Panel7: TPanel
      Left = 904
      Height = 712
      ExplicitLeft = 704
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 712
      ExplicitLeft = 0
      ExplicitHeight = 487
      inherited LinkPanel6: TPanel
        ExplicitLeft = 0
        ExplicitTop = 125
      end
      inherited LinkPanel7: TPanel
        ExplicitLeft = 0
        ExplicitTop = 150
      end
      inherited LinkPanel8: TPanel
        ExplicitTop = 175
      end
      inherited LinkPanel9: TPanel
        ExplicitLeft = 0
        ExplicitTop = 200
      end
      inherited LinkPanel10: TPanel
        ExplicitLeft = 0
        ExplicitTop = 225
      end
    end
    inherited Panel9: TPanel
      Width = 624
      Height = 712
      ExplicitWidth = 424
      ExplicitHeight = 487
      inherited Panel10: TPanel
        Width = 624
        ExplicitWidth = 424
      end
      inherited FramePanel: TPanel
        Top = 512
        Width = 624
        ExplicitTop = 287
        ExplicitWidth = 424
        inherited FrameBank1: TFrameBank
          Width = 622
          ExplicitWidth = 422
        end
        inherited FrameDefault1: TFrameDefault
          Width = 622
          ExplicitWidth = 422
        end
        inherited FrameTavern1: TFrameTavern
          Width = 622
          ExplicitWidth = 422
        end
        inherited FrameOutlands1: TFrameOutlands
          Width = 622
          ExplicitWidth = 422
        end
      end
      inherited Panel19: TPanel
        Width = 624
        Height = 487
        ExplicitWidth = 424
        ExplicitHeight = 262
        inherited FrameInfo1: TFrameInfo
          Width = 622
          Height = 485
          ExplicitWidth = 422
          ExplicitHeight = 260
          inherited StaticText2: TStaticText
            Top = 351
            Width = 622
            ExplicitTop = 126
            ExplicitWidth = 422
          end
          inherited StaticText1: TStaticText
            Width = 622
            Height = 351
            ExplicitWidth = 422
            ExplicitHeight = 126
          end
        end
        inherited FrameLoot1: TFrameLoot
          Width = 622
          Height = 485
          ExplicitWidth = 422
          ExplicitHeight = 260
        end
        inherited FrameBattle1: TFrameBattle
          Width = 622
          Height = 485
          ExplicitWidth = 422
          ExplicitHeight = 260
          inherited Panel1: TPanel
            Width = 622
            Height = 348
            ExplicitWidth = 422
            ExplicitHeight = 123
            inherited RichEdit1: TRichEdit
              Width = 620
              Height = 346
              ExplicitWidth = 420
              ExplicitHeight = 121
            end
          end
          inherited Panel2: TPanel
            Width = 622
            ExplicitWidth = 422
            inherited Panel3: TPanel
              Left = 284
              ExplicitLeft = 84
            end
          end
        end
      end
    end
  end
end
